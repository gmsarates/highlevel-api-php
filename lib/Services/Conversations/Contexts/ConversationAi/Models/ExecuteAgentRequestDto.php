<?php

namespace HighLevel\Services\Conversations\Contexts\ConversationAi\Models;

/**
 * ExecuteAgentRequestDto model (flexible schema)
 *
 * This DTO is used for the AI Agent Studio "Execute Agent" endpoint.
 * Required: locationId
 * Optional: executionId (for session continuation), message (string|object)
 *
 * @package HighLevel\Services\Conversations\Contexts\ConversationAi\Models
 */
class ExecuteAgentRequestDto
{
    /**
     * Common convenience fields (optional; request may include more fields)
     */
    public ?string $location_id = null;
    public ?string $execution_id = null;

    /**
     * Raw message payload (can be string or structured object)
     * @var mixed
     */
    public $message = null;

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
        $this->execution_id = $data['executionId'] ?? $data['execution_id'] ?? null;
        $this->message = $data['message'] ?? null;
        $this->data = $data;
    }

    /**
     * Normalized request payload for the API.
     *
     * @return array<string, mixed>
     */
    public function toRequestArray(): array
    {
        $data = $this->data;

        if (!array_key_exists('locationId', $data) && array_key_exists('location_id', $data)) {
            $data['locationId'] = $data['location_id'];
        }

        if (!array_key_exists('executionId', $data) && array_key_exists('execution_id', $data)) {
            $data['executionId'] = $data['execution_id'];
        }

        if (!array_key_exists('message', $data) && $this->message !== null) {
            $data['message'] = $this->message;
        }

        // Also allow setting via convenience fields
        if (!array_key_exists('locationId', $data) && $this->location_id !== null) {
            $data['locationId'] = $this->location_id;
        }

        if (!array_key_exists('executionId', $data) && $this->execution_id !== null) {
            $data['executionId'] = $this->execution_id;
        }

        return $data;
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

