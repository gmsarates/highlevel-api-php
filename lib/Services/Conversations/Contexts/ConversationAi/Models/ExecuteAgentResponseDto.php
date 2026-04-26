<?php

namespace HighLevel\Services\Conversations\Contexts\ConversationAi\Models;

/**
 * ExecuteAgentResponseDto model (flexible schema)
 *
 * Stores the raw response from the AI Agent Studio "Execute Agent" endpoint
 * and exposes a couple best-effort convenience fields.
 *
 * @package HighLevel\Services\Conversations\Contexts\ConversationAi\Models
 */
class ExecuteAgentResponseDto
{
    public ?string $execution_id = null;

    /**
     * Raw agent output (shape may vary)
     * @var mixed
     */
    public $output = null;

    /**
     * Raw data storage
     * @var array<string, mixed>
     */
    private array $data = [];

    /**
     * @param array<string, mixed> $data
     */
    public function __construct(array $data = [])
    {
        $this->execution_id = $data['executionId'] ?? $data['execution_id'] ?? null;
        $this->output = $data['output'] ?? $data['result'] ?? $data['data'] ?? null;
        $this->data = $data;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return $this->data;
    }

    public function __get(string $name)
    {
        return $this->data[$name] ?? null;
    }

    public function __set(string $name, $value): void
    {
        $this->data[$name] = $value;
    }

    public function __isset(string $name): bool
    {
        return isset($this->data[$name]);
    }
}

