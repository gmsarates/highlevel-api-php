<?php

namespace HighLevel\Services\Conversations\Contexts\ConversationAi\Models;

/**
 * DeleteAgentResponseDto model (flexible schema)
 *
 * The delete endpoint may return an empty body or a confirmation payload.
 *
 * @package HighLevel\Services\Conversations\Contexts\ConversationAi\Models
 */
class DeleteAgentResponseDto
{
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

