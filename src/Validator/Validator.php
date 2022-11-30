<?php

namespace Src\Validator;

use Src\Validator\Rules\Cnpj;
use Src\Validator\Rules\Cpf;
use Src\Validator\Rules\Email;
use Src\Validator\Rules\Required;

/**
 * Class to Validator forms
 * constructor with POST data from form and as rules validation
 * check required fields to check are present in the data
 * check ruless to check are present in the alloweds
 * return an boolean if errors
 */
class Validator
{
    /**
     * @var array
     */
    private array $data;
    /**
     * @var array
     */
    private array $errors = [];
    /**
     * @var array
     */
    private array $fields = [];
    /**
     * @var array|string[]
     */
    protected array $alloweds = ['required', 'email', 'cpf', 'cnpj'];

    /**
     * @param array $formData
     * @param array $fields
     */
    public function __construct(array $formData, array $fields)
    {
        $this->data = $formData;
        $this->fields = $fields;
    }

    /**
     * @return $this
     */
    public function passes(): static
    {
        return $this->validateForm();
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @return bool
     */
    public function fails(): bool
    {
        return count($this->errors) > 0;
    }

    /**
     * @return $this
     */
    private function validateForm(): static
    {
        foreach ($this->fields as $field => $rules) {
            if (is_string($rules) && str_contains($rules, '|')) {
                $rules = explode("|", $rules);
            }

            if (is_array($rules)) {
                $this->validateField($field, $rules);
            }
        }

        return $this;
    }

    /**
     * @param string $field
     * @param array $value
     * @return void
     */
    private function validateField(string $field, array $value): void
    {
        foreach ($value as $rule) {
            $this->checkAllowed($rule);

            switch ($rule) {
                case 'required':
                    $this->required($field);
                    break;
                case 'email':
                    $this->email($field);
                    break;
                case 'cpf':
                    $this->cpf($field);
                    break;
                case 'cnpj':
                    $this->cnpj($field);
                    break;
                default:
                    break;
            }
        }
    }

    /**
     * @param string $field
     * @return void
     */
    private function required(string $field): void
    {
        $value = trim($this->data[$field]);

        if ((new Required($value))->run()) {
            $this->addError($field, "{$field} cannout be empty");
        }
    }

    /**
     * @param string $field
     * @return void
     */
    private function email(string $field): void
    {
        $value = trim($this->data[$field]);

        if (!(new Email($value))->run()) {
            $this->addError($field, 'email must be a valid email');
        }
    }

    /**
     * @param string $field
     * @return void
     */
    private function cpf(string $field): void
    {
        $value = trim($this->data[$field]);

        if (!(new Cpf($value))->run()) {
            $this->addError($field, 'cpf is invalid');
        }
    }

    /**
     * @param string $field
     * @return void
     */
    private function cnpj(string $field): void
    {
        $value = trim($this->data[$field]);

        if (!(new Cnpj($value))->run()) {
            $this->addError($field, 'cnpj is invalid');
        }
    }

    /**
     * @param string $field
     * @param string $message
     * @return void
     */
    private function addError(string $field, string $message): void
    {
        if (!isset($this->errors[$field])) {
            $this->errors[$field] = [$message];
        } else {
            $this->errors[$field][] = $message;
        }
    }

    /**
     * @param string $rule
     * @return void
     */
    public function checkAllowed(string $rule): void
    {
        if (!in_array($rule, $this->alloweds)) {
            trigger_error("Rule: {$rule} is not allowed");
            return;
        }
    }
}