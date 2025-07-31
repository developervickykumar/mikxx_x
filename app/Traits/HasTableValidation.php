<?php

namespace App\Traits;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

trait HasTableValidation
{
    public function validateTableData(array $data): array
    {
        $rules = [];
        $messages = [];

        foreach ($this->columns as $column) {
            $columnRules = $this->getColumnValidationRules($column);
            if (!empty($columnRules)) {
                $rules[$column['name']] = $columnRules;
                $messages = array_merge($messages, $this->getColumnValidationMessages($column));
            }
        }

        try {
            return Validator::validate($data, $rules, $messages);
        } catch (ValidationException $e) {
            throw $e;
        }
    }

    protected function getColumnValidationRules(array $column): array
    {
        $rules = [];

        // Required rule
        if ($column['required'] ?? false) {
            $rules[] = 'required';
        } else {
            $rules[] = 'nullable';
        }

        // Type-specific rules
        $rules = array_merge($rules, match ($column['type']) {
            'text' => ['string', 'max:255'],
            'number' => ['numeric'],
            'decimal' => ['numeric', 'decimal:2'],
            'date' => ['date'],
            'datetime' => ['date'],
            'boolean' => ['boolean'],
            default => ['string'],
        });

        // Custom validation rules from column settings
        if (isset($this->validation_rules[$column['name']])) {
            $rules = array_merge($rules, $this->validation_rules[$column['name']]);
        }

        return $rules;
    }

    protected function getColumnValidationMessages(array $column): array
    {
        $messages = [];
        $columnName = $column['name'];

        // Required message
        if ($column['required'] ?? false) {
            $messages["{$columnName}.required"] = "The {$columnName} field is required.";
        }

        // Type-specific messages
        $messages = array_merge($messages, match ($column['type']) {
            'text' => [
                "{$columnName}.string" => "The {$columnName} must be a string.",
                "{$columnName}.max" => "The {$columnName} may not be greater than 255 characters.",
            ],
            'number' => [
                "{$columnName}.numeric" => "The {$columnName} must be a number.",
            ],
            'decimal' => [
                "{$columnName}.numeric" => "The {$columnName} must be a number.",
                "{$columnName}.decimal" => "The {$columnName} must have 2 decimal places.",
            ],
            'date' => [
                "{$columnName}.date" => "The {$columnName} must be a valid date.",
            ],
            'datetime' => [
                "{$columnName}.date" => "The {$columnName} must be a valid date and time.",
            ],
            'boolean' => [
                "{$columnName}.boolean" => "The {$columnName} must be true or false.",
            ],
            default => [],
        });

        return $messages;
    }

    public function validateColumnDependencies(array $data): bool
    {
        if (empty($this->column_dependencies)) {
            return true;
        }

        foreach ($this->column_dependencies as $column => $dependencies) {
            if (!isset($data[$column])) {
                continue;
            }

            foreach ($dependencies as $dependency) {
                if (!isset($data[$dependency['column']])) {
                    return false;
                }

                if (!$this->validateDependencyCondition($data[$column], $data[$dependency['column']], $dependency['condition'])) {
                    return false;
                }
            }
        }

        return true;
    }

    protected function validateDependencyCondition($value, $dependencyValue, string $condition): bool
    {
        return match ($condition) {
            'equals' => $value === $dependencyValue,
            'not_equals' => $value !== $dependencyValue,
            'greater_than' => $value > $dependencyValue,
            'less_than' => $value < $dependencyValue,
            'greater_than_or_equals' => $value >= $dependencyValue,
            'less_than_or_equals' => $value <= $dependencyValue,
            'contains' => str_contains($value, $dependencyValue),
            'not_contains' => !str_contains($value, $dependencyValue),
            default => true,
        };
    }
} 