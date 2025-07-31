// Form Builder Class
class FormBuilder {
    constructor() {
        this.formFields = [];
        this.initializeEventListeners();
    }

    initializeEventListeners() {
        // Add field button
        document.querySelector('.add-field-btn').addEventListener('click', () => this.addField());

        // Form name input
        document.querySelector('.form-name-input').addEventListener('change', (e) => {
            this.formName = e.target.value;
        });

        // Save form button
        document.querySelector('.save-form-btn').addEventListener('click', () => this.saveForm());

        // Preview form button
        document.querySelector('.preview-form-btn').addEventListener('click', () => this.previewForm());
    }

    addField() {
        const fieldTypes = [
            { type: 'text', label: 'Text Input' },
            { type: 'number', label: 'Number Input' },
            { type: 'email', label: 'Email Input' },
            { type: 'date', label: 'Date Input' },
            { type: 'select', label: 'Select Input' },
            { type: 'checkbox', label: 'Checkbox' },
            { type: 'radio', label: 'Radio Buttons' },
            { type: 'textarea', label: 'Text Area' }
        ];

        const fieldContainer = document.createElement('div');
        fieldContainer.className = 'form-field';
        fieldContainer.innerHTML = `
            <div class="field-header">
                <select class="field-type-select">
                    ${fieldTypes.map(type => `
                        <option value="${type.type}">${type.label}</option>
                    `).join('')}
                </select>
                <input type="text" class="field-label-input" placeholder="Field Label">
                <input type="text" class="field-name-input" placeholder="Field Name">
                <button class="delete-field-btn"><i class="fas fa-times"></i></button>
            </div>
            <div class="field-options">
                <div class="required-option">
                    <input type="checkbox" class="required-checkbox" id="required-${Date.now()}">
                    <label for="required-${Date.now()}">Required</label>
                </div>
                <div class="placeholder-option">
                    <input type="text" class="placeholder-input" placeholder="Placeholder">
                </div>
            </div>
        `;

        document.querySelector('.form-fields-container').appendChild(fieldContainer);

        // Add event listeners for the new field
        this.initializeFieldEventListeners(fieldContainer);
    }

    initializeFieldEventListeners(fieldContainer) {
        // Delete field button
        fieldContainer.querySelector('.delete-field-btn').addEventListener('click', () => {
            fieldContainer.remove();
        });

        // Field type change
        fieldContainer.querySelector('.field-type-select').addEventListener('change', (e) => {
            this.updateFieldOptions(fieldContainer, e.target.value);
        });
    }

    updateFieldOptions(fieldContainer, fieldType) {
        const optionsContainer = fieldContainer.querySelector('.field-options');
        
        switch (fieldType) {
            case 'select':
                optionsContainer.innerHTML = `
                    <div class="required-option">
                        <input type="checkbox" class="required-checkbox" id="required-${Date.now()}">
                        <label for="required-${Date.now()}">Required</label>
                    </div>
                    <div class="options-list">
                        <textarea class="options-textarea" placeholder="Enter options (one per line)"></textarea>
                    </div>
                `;
                break;
            case 'radio':
            case 'checkbox':
                optionsContainer.innerHTML = `
                    <div class="required-option">
                        <input type="checkbox" class="required-checkbox" id="required-${Date.now()}">
                        <label for="required-${Date.now()}">Required</label>
                    </div>
                    <div class="options-list">
                        <textarea class="options-textarea" placeholder="Enter options (one per line)"></textarea>
                    </div>
                `;
                break;
            default:
                optionsContainer.innerHTML = `
                    <div class="required-option">
                        <input type="checkbox" class="required-checkbox" id="required-${Date.now()}">
                        <label for="required-${Date.now()}">Required</label>
                    </div>
                    <div class="placeholder-option">
                        <input type="text" class="placeholder-input" placeholder="Placeholder">
                    </div>
                `;
        }
    }

    getFormData() {
        const fields = [];
        document.querySelectorAll('.form-field').forEach(field => {
            const fieldData = {
                type: field.querySelector('.field-type-select').value,
                label: field.querySelector('.field-label-input').value,
                name: field.querySelector('.field-name-input').value,
                required: field.querySelector('.required-checkbox')?.checked || false,
                placeholder: field.querySelector('.placeholder-input')?.value || '',
                options: field.querySelector('.options-textarea')?.value.split('\n').filter(Boolean) || []
            };
            fields.push(fieldData);
        });

        return {
            name: this.formName,
            fields
        };
    }

    async saveForm() {
        const formData = this.getFormData();
        
        try {
            const response = await fetch('/table-builder/save-form', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(formData)
            });

            const result = await response.json();
            if (result.success) {
                alert('Form saved successfully');
            } else {
                throw new Error(result.message);
            }
        } catch (error) {
            alert('Failed to save form: ' + error.message);
        }
    }

    previewForm() {
        const formData = this.getFormData();
        const previewContainer = document.createElement('div');
        previewContainer.className = 'form-preview';
        previewContainer.innerHTML = `
            <div class="preview-header">
                <h3>${formData.name}</h3>
                <button class="close-preview-btn"><i class="fas fa-times"></i></button>
            </div>
            <form class="preview-form">
                ${formData.fields.map(field => this.generateFieldHTML(field)).join('')}
                <button type="submit" class="submit-btn">Submit</button>
            </form>
        `;

        document.body.appendChild(previewContainer);

        // Add event listeners for the preview
        previewContainer.querySelector('.close-preview-btn').addEventListener('click', () => {
            previewContainer.remove();
        });

        previewContainer.querySelector('.preview-form').addEventListener('submit', (e) => {
            e.preventDefault();
            const formData = new FormData(e.target);
            const data = Object.fromEntries(formData.entries());
            console.log('Form data:', data);
            alert('Form submitted successfully!');
            previewContainer.remove();
        });
    }

    generateFieldHTML(field) {
        switch (field.type) {
            case 'select':
                return `
                    <div class="form-group">
                        <label>${field.label}${field.required ? ' *' : ''}</label>
                        <select name="${field.name}" ${field.required ? 'required' : ''}>
                            <option value="">Select an option</option>
                            ${field.options.map(option => `
                                <option value="${option}">${option}</option>
                            `).join('')}
                        </select>
                    </div>
                `;
            case 'radio':
                return `
                    <div class="form-group">
                        <label>${field.label}${field.required ? ' *' : ''}</label>
                        ${field.options.map(option => `
                            <div class="radio-option">
                                <input type="radio" name="${field.name}" value="${option}" ${field.required ? 'required' : ''}>
                                <label>${option}</label>
                            </div>
                        `).join('')}
                    </div>
                `;
            case 'checkbox':
                return `
                    <div class="form-group">
                        <label>${field.label}${field.required ? ' *' : ''}</label>
                        ${field.options.map(option => `
                            <div class="checkbox-option">
                                <input type="checkbox" name="${field.name}[]" value="${option}" ${field.required ? 'required' : ''}>
                                <label>${option}</label>
                            </div>
                        `).join('')}
                    </div>
                `;
            case 'textarea':
                return `
                    <div class="form-group">
                        <label>${field.label}${field.required ? ' *' : ''}</label>
                        <textarea name="${field.name}" placeholder="${field.placeholder}" ${field.required ? 'required' : ''}></textarea>
                    </div>
                `;
            default:
                return `
                    <div class="form-group">
                        <label>${field.label}${field.required ? ' *' : ''}</label>
                        <input type="${field.type}" name="${field.name}" placeholder="${field.placeholder}" ${field.required ? 'required' : ''}>
                    </div>
                `;
        }
    }
}

// Initialize form builder when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    window.formBuilder = new FormBuilder();
}); 