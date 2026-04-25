<?php

namespace HighLevel\Services\Conversations\Contexts\ConversationAi\Models;

/**
 * AgentRequestDto model (flexible schema)
 *
 * Conversation AI Agents payload shape may evolve. This DTO stores the raw
 * payload and provides a few common convenience fields.
 *
 * @package HighLevel\Services\Conversations\Contexts\ConversationAi\Models
 */
class AgentRequestDto
{
    /**
     * Common convenience fields (optional)
     */
    public ?string $location_id = null;
    public ?string $name = null;
    public ?string $status = null;

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
        $this->location_id = $data['locationId'] ?? $data['location_id'] ?? null;
        $this->name = $data['name'] ?? $data['agentName'] ?? $data['agent_name'] ?? null;
        $this->status = $data['status'] ?? null;
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

