/**
 * DragDropFieldBuilder
 * 
 * A drag-and-drop interface for building and managing form fields.
 * Uses Sortable.js for the drag-and-drop functionality.
 */
class DragDropFieldBuilder {
    /**
     * Initialize the builder
     * 
     * @param {Object} options - Configuration options
     */
    constructor(options = {}) {
        this.options = {
            containerSelector: '#form-builder',
            fieldTypesSelector: '#field-types-list',
            formFieldsSelector: '#form-fields-list',
            deleteZoneSelector: '#delete-zone',
            fieldTypeItemClass: 'field-type-item',
            formFieldItemClass: 'form-field-item',
            fieldTemplateSelector: '#field-template',
            updateOrderEndpoint: null,
            csrfToken: document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
            onFieldAdded: null,
            onFieldRemoved: null,
            onOrderUpdated: null,
            onFieldSelected: null,
            ...options
        };
        
        this.container = document.querySelector(this.options.containerSelector);
        this.fieldTypesList = document.querySelector(this.options.fieldTypesSelector);
        this.formFieldsList = document.querySelector(this.options.formFieldsSelector);
        this.deleteZone = document.querySelector(this.options.deleteZoneSelector);
        this.fieldTemplate = document.querySelector(this.options.fieldTemplateSelector);
        
        this.fieldTypesSortable = null;
        this.formFieldsSortable = null;
        this.selectedField = null;
        
        this.init();
    }
    
    /**
     * Initialize the builder
     */
    init() {
        if (!this.container) {
            console.error('Form builder container not found');
            return;
        }
        
        this.loadSortableJS().then(() => {
            this.initializeSortable();
            this.setupEventListeners();
        });
    }
    
    /**
     * Load Sortable.js dynamically
     */
    loadSortableJS() {
        if (window.Sortable) {
            return Promise.resolve();
        }
        
        return new Promise((resolve, reject) => {
            const script = document.createElement('script');
            script.src = 'https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js';
            script.onload = resolve;
            script.onerror = () => {
                console.error('Failed to load Sortable.js');
                reject();
            };
            document.head.appendChild(script);
        });
    }
    
    /**
     * Initialize Sortable instances
     */
    initializeSortable() {
        // Make field types draggable (as copies)
        this.fieldTypesSortable = Sortable.create(this.fieldTypesList, {
            group: {
                name: 'fieldTypes',
                pull: 'clone',
                put: false
            },
            sort: false,
            animation: 150,
            ghostClass: 'sortable-ghost',
            chosenClass: 'sortable-chosen',
            dragClass: 'sortable-drag',
            onEnd: (evt) => {
                // If dropped into form fields list, it's handled by the other Sortable instance
                // If dropped elsewhere (except delete zone), just remove the clone
                if (evt.to !== this.formFieldsList && evt.to !== this.deleteZone) {
                    evt.item.remove();
                }
            }
        });
        
        // Make form fields sortable
        this.formFieldsSortable = Sortable.create(this.formFieldsList, {
            group: {
                name: 'formFields',
                pull: true,
                put: ['fieldTypes']
            },
            animation: 150,
            ghostClass: 'sortable-ghost',
            chosenClass: 'sortable-chosen',
            dragClass: 'sortable-drag',
            handle: '.drag-handle',
            onAdd: (evt) => this.handleFieldAdded(evt),
            onUpdate: (evt) => this.handleOrderUpdated(evt),
            onEnd: (evt) => {
                // If dropped into delete zone, remove it
                if (evt.to === this.deleteZone) {
                    this.handleFieldRemoved(evt.item);
                    evt.item.remove();
                }
            }
        });
        
        // Setup delete zone
        if (this.deleteZone) {
            Sortable.create(this.deleteZone, {
                group: {
                    name: 'deleteZone',
                    pull: false,
                    put: ['formFields']
                },
                sort: false,
                animation: 150,
                onAdd: (evt) => {
                    this.handleFieldRemoved(evt.item);
                    evt.item.remove();
                }
            });
        }
    }
    
    /**
     * Set up event listeners
     */
    setupEventListeners() {
        // Add click event for field selection
        if (this.formFieldsList) {
            this.formFieldsList.addEventListener('click', (event) => {
                const fieldItem = event.target.closest(`.${this.options.formFieldItemClass}`);
                if (fieldItem) {
                    this.selectField(fieldItem);
                }
            });
        }
        
        // Add double-click for field types to quickly add them
        if (this.fieldTypesList) {
            this.fieldTypesList.addEventListener('dblclick', (event) => {
                const fieldTypeItem = event.target.closest(`.${this.options.fieldTypeItemClass}`);
                if (fieldTypeItem) {
                    this.quickAddField(fieldTypeItem);
                }
            });
        }
    }
    
    /**
     * Handle when a new field is added to the form
     * 
     * @param {Object} evt - Sortable event object
     */
    handleFieldAdded(evt) {
        const fieldTypeItem = evt.item;
        
        // Get field type data
        const fieldTypeId = fieldTypeItem.dataset.fieldTypeId;
        const fieldTypeName = fieldTypeItem.dataset.name;
        const componentName = fieldTypeItem.dataset.componentName;
        
        // Create a proper form field from the field type
        const newField = this.createFormField({
            fieldTypeId,
            fieldTypeName,
            componentName
        });
        
        // Replace the dragged field type item with the new form field
        this.formFieldsList.replaceChild(newField, fieldTypeItem);
        
        // Select the new field
        this.selectField(newField);
        
        // Update order
        this.updateFieldOrder();
        
        // Call callback if provided
        if (typeof this.options.onFieldAdded === 'function') {
            this.options.onFieldAdded(newField);
        }
    }
    
    /**
     * Create a form field element
     * 
     * @param {Object} data - Field data
     * @returns {HTMLElement} The created form field element
     */
    createFormField(data) {
        let newField;
        
        if (this.fieldTemplate) {
            // If we have a template, use it
            const template = this.fieldTemplate.innerHTML;
            
            // Create a temporary container
            const tempContainer = document.createElement('div');
            
            // Replace placeholders in the template
            tempContainer.innerHTML = template
                .replace(/\{\{fieldTypeId\}\}/g, data.fieldTypeId)
                .replace(/\{\{fieldTypeName\}\}/g, data.fieldTypeName)
                .replace(/\{\{componentName\}\}/g, data.componentName)
                .replace(/\{\{fieldId\}\}/g, 'new_' + Date.now())
                .replace(/\{\{order\}\}/g, this.getNextOrderValue())
                .trim();
            
            // Get the field element
            newField = tempContainer.firstElementChild;
        } else {
            // If no template, create a basic element
            newField = document.createElement('div');
            newField.className = this.options.formFieldItemClass;
            newField.dataset.fieldTypeId = data.fieldTypeId;
            newField.dataset.order = this.getNextOrderValue();
            
            const dragHandle = document.createElement('div');
            dragHandle.className = 'drag-handle';
            dragHandle.innerHTML = '<i class="fas fa-grip-vertical"></i>';
            
            const fieldName = document.createElement('div');
            fieldName.className = 'field-name';
            fieldName.textContent = data.fieldTypeName;
            
            const deleteBtn = document.createElement('button');
            deleteBtn.className = 'btn btn-sm btn-danger delete-field';
            deleteBtn.innerHTML = '<i class="fas fa-trash"></i>';
            deleteBtn.type = 'button';
            deleteBtn.addEventListener('click', () => this.handleFieldRemoved(newField));
            
            newField.appendChild(dragHandle);
            newField.appendChild(fieldName);
            newField.appendChild(deleteBtn);
        }
        
        return newField;
    }
    
    /**
     * Get the next order value for a new field
     * 
     * @returns {number} The next order value
     */
    getNextOrderValue() {
        let maxOrder = 0;
        
        if (this.formFieldsList) {
            const fields = this.formFieldsList.querySelectorAll(`.${this.options.formFieldItemClass}`);
            fields.forEach(field => {
                const order = parseInt(field.dataset.order || 0, 10);
                if (order > maxOrder) {
                    maxOrder = order;
                }
            });
        }
        
        return maxOrder + 1;
    }
    
    /**
     * Handle when the order of fields is updated
     * 
     * @param {Object} evt - Sortable event object
     */
    handleOrderUpdated(evt) {
        this.updateFieldOrder();
        
        // Call callback if provided
        if (typeof this.options.onOrderUpdated === 'function') {
            this.options.onOrderUpdated();
        }
    }
    
    /**
     * Update the order attribute of all fields
     */
    updateFieldOrder() {
        const fields = this.formFieldsList.querySelectorAll(`.${this.options.formFieldItemClass}`);
        
        fields.forEach((field, index) => {
            field.dataset.order = index + 1;
            
            // Update order input if it exists
            const orderInput = field.querySelector('input[name$="[order]"]');
            if (orderInput) {
                orderInput.value = index + 1;
            }
        });
        
        // Send order to server if endpoint is set
        if (this.options.updateOrderEndpoint) {
            this.saveFieldOrder();
        }
    }
    
    /**
     * Save the field order to the server
     */
    saveFieldOrder() {
        const fields = this.formFieldsList.querySelectorAll(`.${this.options.formFieldItemClass}`);
        const orderData = [];
        
        fields.forEach(field => {
            const fieldId = field.dataset.fieldId;
            const order = field.dataset.order;
            
            // Only send existing fields (not new ones)
            if (fieldId && !fieldId.startsWith('new_')) {
                orderData.push({
                    id: fieldId,
                    order: order
                });
            }
        });
        
        if (orderData.length === 0) return;
        
        fetch(this.options.updateOrderEndpoint, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': this.options.csrfToken
            },
            body: JSON.stringify({ fields: orderData })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('Field order updated successfully');
            } else {
                console.error('Error updating field order:', data.message);
            }
        })
        .catch(error => {
            console.error('Error updating field order:', error);
        });
    }
    
    /**
     * Handle when a field is removed
     * 
     * @param {HTMLElement} fieldItem - The field item being removed
     */
    handleFieldRemoved(fieldItem) {
        // If this is the selected field, deselect it
        if (this.selectedField === fieldItem) {
            this.deselectField();
        }
        
        // Call callback if provided
        if (typeof this.options.onFieldRemoved === 'function') {
            this.options.onFieldRemoved(fieldItem);
        }
        
        // Update order
        setTimeout(() => this.updateFieldOrder(), 0);
    }
    
    /**
     * Select a field
     * 
     * @param {HTMLElement} fieldItem - The field item to select
     */
    selectField(fieldItem) {
        // Deselect previously selected field
        this.deselectField();
        
        // Select the new field
        fieldItem.classList.add('selected');
        this.selectedField = fieldItem;
        
        // Call callback if provided
        if (typeof this.options.onFieldSelected === 'function') {
            this.options.onFieldSelected(fieldItem);
        }
    }
    
    /**
     * Deselect the currently selected field
     */
    deselectField() {
        if (this.selectedField) {
            this.selectedField.classList.remove('selected');
            this.selectedField = null;
        }
    }
    
    /**
     * Quick add a field by double-clicking on a field type
     * 
     * @param {HTMLElement} fieldTypeItem - The field type item to add
     */
    quickAddField(fieldTypeItem) {
        // Clone the field type item
        const clone = fieldTypeItem.cloneNode(true);
        
        // Append to form fields list
        this.formFieldsList.appendChild(clone);
        
        // Trigger the onAdd handler
        this.handleFieldAdded({ item: clone });
    }
    
    /**
     * Get all form fields data
     * 
     * @returns {Array} Array of field data objects
     */
    getFieldsData() {
        const fields = this.formFieldsList.querySelectorAll(`.${this.options.formFieldItemClass}`);
        const fieldsData = [];
        
        fields.forEach(field => {
            const fieldData = {
                field_type_id: field.dataset.fieldTypeId,
                order: field.dataset.order
            };
            
            // Get all field properties from inputs
            const inputs = field.querySelectorAll('input, select, textarea');
            inputs.forEach(input => {
                const name = input.name;
                if (name) {
                    // Extract the property name from the input name (e.g., "fields[0][label]" -> "label")
                    const matches = name.match(/\[([^\]]+)\]$/);
                    if (matches && matches[1]) {
                        const prop = matches[1];
                        fieldData[prop] = input.value;
                    }
                }
            });
            
            fieldsData.push(fieldData);
        });
        
        return fieldsData;
    }
    
    /**
     * Add a new field programmatically
     * 
     * @param {Object} fieldData - Field data object
     * @returns {HTMLElement} The created field element
     */
    addField(fieldData) {
        const newField = this.createFormField(fieldData);
        this.formFieldsList.appendChild(newField);
        
        // Update order
        this.updateFieldOrder();
        
        // Call callback if provided
        if (typeof this.options.onFieldAdded === 'function') {
            this.options.onFieldAdded(newField);
        }
        
        return newField;
    }
    
    /**
     * Remove a field programmatically
     * 
     * @param {string|HTMLElement} fieldId - Field ID or field element
     * @returns {boolean} Whether the field was removed
     */
    removeField(fieldId) {
        let fieldItem;
        
        if (typeof fieldId === 'string') {
            fieldItem = this.formFieldsList.querySelector(`.${this.options.formFieldItemClass}[data-field-id="${fieldId}"]`);
        } else {
            fieldItem = fieldId;
        }
        
        if (!fieldItem) {
            return false;
        }
        
        this.handleFieldRemoved(fieldItem);
        fieldItem.remove();
        
        return true;
    }
}

// Export the builder
export default DragDropFieldBuilder; 