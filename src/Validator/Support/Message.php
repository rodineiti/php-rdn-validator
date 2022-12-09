<?php

namespace RdnValidator\Validator\Support;

class Message
{
    /**
     * @var array
     */
    private array $messages;
    /**
     * @var string
     */
    private string $field;
    /**
     * @var string
     */
    private string $type;

    /**
     * @param string $field
     * @param string $type
     * @param array $messages
     */
    public function __construct(string $field, string $type, array $messages = [])
    {
        $this->messages = $messages;
        $this->field = $field;
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function get(): string
    {
        return match ($this->type) {
            'required' => $this->getMessage() ?? "{$this->field} is required",
            'email', 'cpf', 'cnpj' => $this->getMessage() ?? "{$this->field} is invalid",
            default => '',
        };
    }

    /**
     * @return string|null
     */
    private function getMessage(): string|null
    {
        $message = $this->messages[$this->type] ?? null;

        if ($message && str_contains($message, ":field")) {
            return str_replace(":field", $this->field, $message);
        }

        return $message;
    }
}