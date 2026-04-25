<?php

namespace HighLevel\Services\Conversations\Contexts\ConversationAi\Models;

/**
 * AgentResponseDto model (flexible schema)
 *
 * Attempts to expose a few common fields while keeping the original response.
 *
 * @package HighLevel\Services\Conversations\Contexts\ConversationAi\Models
 */
class AgentResponseDto
{
    /**
     * Common convenience fields (best-effort)
     */
    public string $id = '';
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
        $agent = $this->extractAgentObject($data);

        $this->id = (string) ($agent['id'] ?? $agent['agentId'] ?? $data['id'] ?? '');
        $this->location_id = $agent['locationId'] ?? $agent['location_id'] ?? $data['locationId'] ?? $data['location_id'] ?? null;
        $this->name = $agent['name'] ?? $agent['agentName'] ?? $agent['agent_name'] ?? $data['name'] ?? $data['agentName'] ?? null;
        $this->status = $agent['status'] ?? $data['status'] ?? null;

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

    /**
     * Best-effort extraction of the agent object from common response wrappers.
     *
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    private function extractAgentObject(array $data): array
    {
        if (isset($data['agent']) && is_array($data['agent'])) {
            return $data['agent'];
        }

        if (isset($data['data']) && is_array($data['data'])) {
            return $data['data'];
        }

        // If the response already looks like an agent object, return as-is
        if (isset($data['id']) || isset($data['name']) || isset($data['agentName'])) {
            return $data;
        }

        return [];
    }
}

