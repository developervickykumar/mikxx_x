/**
 * FieldDependency Component
 * 
 * This component handles field dependencies in forms.
 * It allows showing/hiding fields based on conditions from other fields.
 */
class FieldDependency {
    /**
     * Initialize the dependency manager
     * 
     * @param {Object} options - Configuration options
     */
    constructor(options = {}) {
        this.options = {
            formSelector: 'form',
            conditionsEndpoint: null,
            dependencyDataAttribute: 'data-dependencies',
            csrfToken: document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
            ...options
        };
        
        this.form = document.querySelector(this.options.formSelector);
        this.dependencies = [];
        this.watchedFields = new Set();
        
        this.init();
    }
    
    /**
     * Initialize the dependency manager
     */
    init() {
        if (!this.form) {
            console.error('Form not found for field dependencies');
            return;
        }
        
        this.loadDependencies();
        this.attachEventListeners();
        this.evaluateAllDependencies();
    }
    
    /**
     * Load dependencies from field data attributes
     */
    loadDependencies() {
        const dependencyFields = this.form.querySelectorAll(`[${this.options.dependencyDataAttribute}]`);
        
        dependencyFields.forEach(field => {
            try {
                const dependencyData = JSON.parse(field.getAttribute(this.options.dependencyDataAttribute));
                
                if (Array.isArray(dependencyData) && dependencyData.length > 0) {
                    this.dependencies.push({
                        targetField: field,
                        conditions: dependencyData
                    });
                    
                    // Add source fields to watched fields
                    dependencyData.forEach(condition => {
                        if (condition.field) {
                            this.watchedFields.add(condition.field);
                        }
                    });
                }
            } catch (e) {
                console.error('Error parsing dependency data:', e);
            }
        });
    }
    
    /**
     * Attach event listeners to watched fields
     */
    attachEventListeners() {
        this.watchedFields.forEach(fieldName => {
            const fields = this.form.querySelectorAll(`[name="${fieldName}"], [name="${fieldName}[]"]`);
            
            fields.forEach(field => {
                let eventType = 'change';
                
                if (field.tagName === 'INPUT') {
                    if (field.type === 'text' || field.type === 'number' || field.type === 'email' || field.type === 'password') {
                        eventType = 'input';
                    }
                }
                
                field.addEventListener(eventType, () => this.evaluateAllDependencies());
            });
        });
    }
    
    /**
     * Evaluate all dependencies
     */
    evaluateAllDependencies() {
        this.dependencies.forEach(dependency => {
            this.evaluateDependency(dependency);
        });
    }
    
    /**
     * Evaluate a single dependency
     * 
     * @param {Object} dependency - Dependency object
     */
    evaluateDependency(dependency) {
        const { targetField, conditions } = dependency;
        
        if (!targetField || !conditions || conditions.length === 0) {
            return;
        }
        
        // Get field values and evaluate conditions
        const fieldValues = this.getFieldValues();
        const result = this.evaluateConditions(conditions, fieldValues);
        
        // Show/hide target field based on result
        this.toggleField(targetField, result);
    }
    
    /**
     * Get all field values from the form
     * 
     * @returns {Object} Object with field names and values
     */
    getFieldValues() {
        const values = {};
        
        this.watchedFields.forEach(fieldName => {
            const fields = this.form.querySelectorAll(`[name="${fieldName}"], [name="${fieldName}[]"]`);
            
            if (fields.length === 0) {
                values[fieldName] = null;
                return;
            }
            
            if (fields.length === 1) {
                const field = fields[0];
                
                if (field.type === 'checkbox') {
                    values[fieldName] = field.checked;
                } else if (field.type === 'radio') {
                    const checkedRadio = this.form.querySelector(`[name="${fieldName}"]:checked`);
                    values[fieldName] = checkedRadio ? checkedRadio.value : null;
                } else {
                    values[fieldName] = field.value;
                }
            } else {
                // Multiple fields with the same name (select multiple, checkbox group)
                if (fields[0].type === 'checkbox') {
                    values[fieldName] = Array.from(fields)
                        .filter(field => field.checked)
                        .map(field => field.value);
                } else {
                    values[fieldName] = Array.from(fields).map(field => field.value);
                }
            }
        });
        
        return values;
    }
    
    /**
     * Evaluate conditions against field values
     * 
     * @param {Array} conditions - Array of condition objects
     * @param {Object} fieldValues - Object with field values
     * @returns {boolean} Whether conditions are met
     */
    evaluateConditions(conditions, fieldValues) {
        if (!conditions || conditions.length === 0) {
            return true;
        }
        
        if (this.options.conditionsEndpoint) {
            // For complex conditions, use server-side evaluation
            return this.evaluateConditionsOnServer(conditions, fieldValues);
        }
        
        // Simple client-side evaluation
        let result = true;
        
        for (const condition of conditions) {
            const { field, operator, value, logic } = condition;
            
            if (!field || !operator) {
                continue;
            }
            
            const fieldValue = fieldValues[field];
            let conditionResult = this.evaluateCondition(fieldValue, operator, value);
            
            if (logic === 'or') {
                result = result || conditionResult;
            } else {
                // Default to 'and' logic
                result = result && conditionResult;
            }
        }
        
        return result;
    }
    
    /**
     * Evaluate a single condition
     * 
     * @param {*} fieldValue - The value of the field
     * @param {string} operator - The comparison operator
     * @param {*} compareValue - The value to compare against
     * @returns {boolean} Whether the condition is met
     */
    evaluateCondition(fieldValue, operator, compareValue) {
        switch (operator) {
            case 'equals':
                return fieldValue == compareValue;
            case 'not_equals':
                return fieldValue != compareValue;
            case 'contains':
                if (Array.isArray(fieldValue)) {
                    return fieldValue.includes(compareValue);
                }
                return String(fieldValue).includes(String(compareValue));
            case 'not_contains':
                if (Array.isArray(fieldValue)) {
                    return !fieldValue.includes(compareValue);
                }
                return !String(fieldValue).includes(String(compareValue));
            case 'greater_than':
                return Number(fieldValue) > Number(compareValue);
            case 'less_than':
                return Number(fieldValue) < Number(compareValue);
            case 'empty':
                return !fieldValue || (Array.isArray(fieldValue) && fieldValue.length === 0) || fieldValue === '';
            case 'not_empty':
                return fieldValue && (!Array.isArray(fieldValue) || fieldValue.length > 0) && fieldValue !== '';
            default:
                return false;
        }
    }
    
    /**
     * Evaluate conditions on the server
     * 
     * @param {Array} conditions - Array of condition objects
     * @param {Object} fieldValues - Object with field values
     * @returns {boolean} Whether conditions are met
     */
    evaluateConditionsOnServer(conditions, fieldValues) {
        if (!this.options.conditionsEndpoint) {
            return false;
        }
        
        fetch(this.options.conditionsEndpoint, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': this.options.csrfToken
            },
            body: JSON.stringify({
                conditions: conditions,
                values: fieldValues
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.result !== undefined) {
                return data.result;
            }
            return false;
        })
        .catch(error => {
            console.error('Error evaluating conditions:', error);
            return false;
        });
    }
    
    /**
     * Toggle visibility of a field based on condition result
     * 
     * @param {HTMLElement} field - The field to toggle
     * @param {boolean} isVisible - Whether the field should be visible
     */
    toggleField(field, isVisible) {
        // Get the field container (usually a div.form-group or similar)
        const container = field.closest('.form-group, .mb-3, .field-container') || field;
        
        if (isVisible) {
            container.style.display = '';
            // If the field has the required attribute, restore it
            if (container.dataset.wasRequired === 'true') {
                field.setAttribute('required', '');
                delete container.dataset.wasRequired;
            }
        } else {
            container.style.display = 'none';
            // If the field has the required attribute, remove it temporarily
            if (field.hasAttribute('required')) {
                container.dataset.wasRequired = 'true';
                field.removeAttribute('required');
            }
        }
    }
    
    /**
     * Add a new dependency programmatically
     * 
     * @param {HTMLElement} targetField - The field to show/hide
     * @param {Array} conditions - Array of condition objects
     */
    addDependency(targetField, conditions) {
        if (!targetField || !Array.isArray(conditions) || conditions.length === 0) {
            return;
        }
        
        // Store dependency
        this.dependencies.push({
            targetField: targetField,
            conditions: conditions
        });
        
        // Add source fields to watched fields
        conditions.forEach(condition => {
            if (condition.field) {
                this.watchedFields.add(condition.field);
            }
        });
        
        // Update event listeners
        this.attachEventListeners();
        
        // Set data attribute for serialization
        targetField.setAttribute(this.options.dependencyDataAttribute, JSON.stringify(conditions));
        
        // Evaluate immediately
        this.evaluateAllDependencies();
    }
    
    /**
     * Remove a dependency for a field
     * 
     * @param {HTMLElement} targetField - The field to remove dependencies for
     */
    removeDependency(targetField) {
        if (!targetField) {
            return;
        }
        
        // Filter out dependencies for this field
        this.dependencies = this.dependencies.filter(dep => dep.targetField !== targetField);
        
        // Remove data attribute
        targetField.removeAttribute(this.options.dependencyDataAttribute);
        
        // Recalculate watched fields
        this.watchedFields.clear();
        this.dependencies.forEach(dep => {
            dep.conditions.forEach(condition => {
                if (condition.field) {
                    this.watchedFields.add(condition.field);
                }
            });
        });
        
        // Update event listeners
        this.attachEventListeners();
        
        // Show the field since it no longer has dependencies
        this.toggleField(targetField, true);
    }
}

// Export the dependency manager
export default FieldDependency; 