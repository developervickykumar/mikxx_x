/**
 * Field Validator Component
 * 
 * This component handles form field validation using JSON Schema.
 * It provides real-time validation feedback for form fields.
 */
class FieldValidator {
    /**
     * Initialize the validator
     * 
     * @param {Object} schema - JSON Schema validation object
     * @param {Object} options - Configuration options
     */
    constructor(schema, options = {}) {
        this.schema = schema;
        this.options = {
            validateOnBlur: true,
            validateOnInput: false,
            validateOnSubmit: true,
            showErrorMessages: true,
            errorClass: 'is-invalid',
            successClass: 'is-valid',
            errorMessageClass: 'invalid-feedback',
            ...options
        };
        
        this.errors = {};
        this.form = null;
        this.ajv = null;
        this.validate = null;
    }
    
    /**
     * Initialize the validator on a form
     * 
     * @param {HTMLFormElement} form - The form to attach validation to
     */
    init(form) {
        if (!form) {
            console.error('No form provided to FieldValidator');
            return;
        }
        
        this.form = form;
        
        // Load Ajv if not already loaded
        this.loadAjv().then(() => {
            this.setupValidator();
            this.attachEventListeners();
        });
    }
    
    /**
     * Load Ajv (JSON Schema validator) dynamically
     */
    async loadAjv() {
        if (window.Ajv) {
            this.ajv = new window.Ajv({ allErrors: true });
            return;
        }
        
        return new Promise((resolve, reject) => {
            const script = document.createElement('script');
            script.src = 'https://cdnjs.cloudflare.com/ajax/libs/ajv/8.12.0/ajv.min.js';
            script.onload = () => {
                this.ajv = new window.Ajv({ allErrors: true });
                resolve();
            };
            script.onerror = () => {
                console.error('Failed to load Ajv for validation');
                reject();
            };
            document.head.appendChild(script);
        });
    }
    
    /**
     * Set up the validator with the provided schema
     */
    setupValidator() {
        this.validate = this.ajv.compile(this.schema);
    }
    
    /**
     * Attach event listeners to form fields
     */
    attachEventListeners() {
        const formFields = this.form.querySelectorAll('input, select, textarea');
        
        formFields.forEach(field => {
            if (this.options.validateOnBlur) {
                field.addEventListener('blur', () => this.validateField(field));
            }
            
            if (this.options.validateOnInput) {
                field.addEventListener('input', () => this.validateField(field));
            }
        });
        
        if (this.options.validateOnSubmit) {
            this.form.addEventListener('submit', (e) => {
                const isValid = this.validateForm();
                if (!isValid) {
                    e.preventDefault();
                    this.focusFirstInvalidField();
                }
            });
        }
    }
    
    /**
     * Validate a single field
     * 
     * @param {HTMLElement} field - The field to validate
     * @returns {boolean} Whether the field is valid
     */
    validateField(field) {
        const name = field.name;
        if (!name) return true;
        
        const value = this.getFieldValue(field);
        const data = { [name]: value };
        
        this.validate(data);
        
        const fieldErrors = this.findErrorsForField(name);
        this.errors[name] = fieldErrors;
        
        this.updateFieldUI(field, fieldErrors);
        
        return fieldErrors.length === 0;
    }
    
    /**
     * Get the value of a field, accounting for different field types
     * 
     * @param {HTMLElement} field - The field to get the value from
     * @returns {*} The field value
     */
    getFieldValue(field) {
        if (field.type === 'checkbox') {
            return field.checked;
        } else if (field.type === 'radio') {
            const checkedRadio = this.form.querySelector(`input[name="${field.name}"]:checked`);
            return checkedRadio ? checkedRadio.value : '';
        } else if (field.type === 'file') {
            return field.files;
        } else if (field.type === 'select-multiple') {
            return Array.from(field.selectedOptions).map(option => option.value);
        } else {
            return field.value;
        }
    }
    
    /**
     * Find errors for a specific field from validation results
     * 
     * @param {string} fieldName - The name of the field
     * @returns {Array} Array of error messages
     */
    findErrorsForField(fieldName) {
        if (!this.validate.errors) return [];
        
        return this.validate.errors
            .filter(error => error.instancePath === `/$(fieldName)` || error.params.missingProperty === fieldName)
            .map(error => this.formatError(error));
    }
    
    /**
     * Format an error message from Ajv
     * 
     * @param {Object} error - Ajv error object
     * @returns {string} Formatted error message
     */
    formatError(error) {
        switch (error.keyword) {
            case 'required':
                return 'This field is required';
            case 'format':
                return `Invalid format: ${error.params.format}`;
            case 'minLength':
                return `Should be at least ${error.params.limit} characters`;
            case 'maxLength':
                return `Should be at most ${error.params.limit} characters`;
            case 'minimum':
                return `Should be at least ${error.params.limit}`;
            case 'maximum':
                return `Should be at most ${error.params.limit}`;
            case 'type':
                return `Should be a ${error.params.type}`;
            case 'pattern':
                return 'Invalid format';
            default:
                return error.message;
        }
    }
    
    /**
     * Update the UI for a field based on validation status
     * 
     * @param {HTMLElement} field - The field to update
     * @param {Array} errors - Array of error messages
     */
    updateFieldUI(field, errors) {
        // Remove existing classes and messages
        field.classList.remove(this.options.errorClass, this.options.successClass);
        
        // Remove existing error message
        const container = field.parentNode;
        const existingError = container.querySelector(`.${this.options.errorMessageClass}`);
        if (existingError) {
            existingError.remove();
        }
        
        // Add appropriate classes and error message
        if (errors.length > 0) {
            field.classList.add(this.options.errorClass);
            
            if (this.options.showErrorMessages) {
                const errorElement = document.createElement('div');
                errorElement.className = this.options.errorMessageClass;
                errorElement.textContent = errors[0];
                container.appendChild(errorElement);
            }
        } else {
            field.classList.add(this.options.successClass);
        }
    }
    
    /**
     * Validate the entire form
     * 
     * @returns {boolean} Whether the form is valid
     */
    validateForm() {
        const formFields = this.form.querySelectorAll('input, select, textarea');
        let isValid = true;
        
        formFields.forEach(field => {
            const fieldValid = this.validateField(field);
            if (!fieldValid) {
                isValid = false;
            }
        });
        
        return isValid;
    }
    
    /**
     * Focus the first invalid field in the form
     */
    focusFirstInvalidField() {
        const invalidField = this.form.querySelector(`.${this.options.errorClass}`);
        if (invalidField) {
            invalidField.focus();
        }
    }
    
    /**
     * Set custom validation rules
     * 
     * @param {Object} schema - JSON Schema validation object
     */
    setSchema(schema) {
        this.schema = schema;
        this.setupValidator();
    }
}

// Export the validator
export default FieldValidator; 