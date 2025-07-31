class FormConditions {
    constructor(formId) {
        this.form = document.getElementById(formId);
        this.conditions = [];
        this.initialize();
    }

    initialize() {
        if (!this.form) return;

        // Load conditions from data attributes
        this.loadConditions();

        // Add event listeners to all form fields
        this.form.querySelectorAll('input, select, textarea').forEach(field => {
            field.addEventListener('change', () => this.evaluateConditions(field));
            field.addEventListener('input', () => this.evaluateConditions(field));
        });
    }

    loadConditions() {
        const conditionsData = this.form.dataset.conditions;
        if (conditionsData) {
            this.conditions = JSON.parse(conditionsData);
        }
    }

    evaluateConditions(changedField) {
        const fieldName = changedField.name;
        const fieldValue = this.getFieldValue(changedField);

        this.conditions.forEach(condition => {
            if (condition.source_field === fieldName) {
                const targetField = this.form.querySelector(`[name="${condition.target_field}"]`);
                if (!targetField) return;

                const conditionMet = this.evaluateCondition(condition, fieldValue);
                this.applyCondition(condition, targetField, conditionMet);
            }
        });
    }

    getFieldValue(field) {
        if (field.type === 'checkbox') {
            return field.checked;
        } else if (field.type === 'select-multiple') {
            return Array.from(field.selectedOptions).map(option => option.value);
        }
        return field.value;
    }

    evaluateCondition(condition, value) {
        switch (condition.operator) {
            case 'equals':
                return value == condition.value;
            case 'not_equals':
                return value != condition.value;
            case 'contains':
                return value.includes(condition.value);
            case 'greater_than':
                return parseFloat(value) > parseFloat(condition.value);
            case 'less_than':
                return parseFloat(value) < parseFloat(condition.value);
            case 'in':
                return condition.value.split(',').includes(value);
            case 'not_in':
                return !condition.value.split(',').includes(value);
            default:
                return false;
        }
    }

    applyCondition(condition, targetField, conditionMet) {
        switch (condition.condition_type) {
            case 'show':
                targetField.closest('.form-group').style.display = conditionMet ? 'block' : 'none';
                break;
            case 'hide':
                targetField.closest('.form-group').style.display = conditionMet ? 'none' : 'block';
                break;
            case 'enable':
                targetField.disabled = !conditionMet;
                break;
            case 'disable':
                targetField.disabled = conditionMet;
                break;
            case 'require':
                targetField.required = conditionMet;
                break;
        }
    }
}

// Initialize form conditions when the document is ready
document.addEventListener('DOMContentLoaded', () => {
    const forms = document.querySelectorAll('[data-conditions]');
    forms.forEach(form => {
        new FormConditions(form.id);
    });
}); 