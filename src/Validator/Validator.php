<?php

namespace RdnValidator\Validator;

use RdnValidator\Validator\Rules\Cnpj;
use RdnValidator\Validator\Rules\Cpf;
use RdnValidator\Validator\Rules\Email;
use RdnValidator\Validator\Rules\Required;
use RdnValidator\Validator\Support\Message;

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
     * @var array
     */
    private array $messages = [];

    /**
     * @param array $formData
     * @param array $fields
     */
    public function __construct(array $formData, array $fields, array $messages = [])
    {
        $this->data = $formData;
        $this->fields = $fields;
        $this->messages = $messages;
    }

    /**
     * @return $this
     */
    public static function passes(array $formData, array $fields, array $messages = []): self
    {
        $instance = new self($formData, $fields, $messages);
        return $instance->validateForm();
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @param string $key
     * @return string|null
     */
    public function getError(string $key): string|null
    {
        return $this->errors[$key][0] ?? null;
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
    private function validateForm(): self
    {
        foreach ($this->fields as $field => $rules) {
            if (is_string($rules)) {
                $rules = explode("|", $rules);
            }

            $this->validateField($field, $rules);
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
            $this->addError($field, "required");
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
            $this->addError($field, 'email');
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
            $this->addError($field, 'cpf');
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
            $this->addError($field, 'cnpj');
        }
    }

    /**
     * @param string $field
     * @param string $type
     * @return void
     */
    private function addError(string $field, string $type): void
    {
        $message = new Message($field, $type, $this->messages);

        if (!isset($this->errors[$field])) {
            $this->errors[$field] = [$message->get()];
        } else {
            $this->errors[$field][] = $message->get();
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