<?php

namespace HighLevel\Services\Conversations\Contexts\ConversationAi\Models;

/**
 * SearchAgentsResponseDto model (flexible schema)
 *
 * @package HighLevel\Services\Conversations\Contexts\ConversationAi\Models
 */
class SearchAgentsResponseDto
{
    /**
     * Parsed list of agents when present
     * @var array<AgentResponseDto>|null
     */
    public ?array $agents = null;

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
        $agents = null;

        if (isset($data['agents']) && is_array($data['agents'])) {
            $agents = $data['agents'];
        } elseif (isset($data['data']) && is_array($data['data'])) {
            // Some APIs wrap results in `data`
            $agents = $data['data'];
        } elseif (isset($data['items']) && is_array($data['items'])) {
            $agents = $data['items'];
        }

        if (is_array($agents)) {
            $this->agents = array_map(function ($item) {
                return is_array($item) ? new AgentResponseDto($item) : $item;
            }, $agents);
        }

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

