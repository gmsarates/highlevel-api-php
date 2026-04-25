<?php

namespace HighLevel\Services\Conversations\Contexts\ConversationAi;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use HighLevel\GHLError;
use HighLevel\HighLevel;
use HighLevel\Services\Conversations\Contexts\ConversationAi\Models\AgentRequestDto;
use HighLevel\Services\Conversations\Contexts\ConversationAi\Models\AgentResponseDto;
use HighLevel\Services\Conversations\Contexts\ConversationAi\Models\DeleteAgentResponseDto;
use HighLevel\Services\Conversations\Contexts\ConversationAi\Models\SearchAgentsResponseDto;
use HighLevel\Utils\RequestUtils;

/**
 * Conversation AI - Agents resource
 *
 * @package HighLevel\Services\Conversations\Contexts\ConversationAi
 */
class Agents
{
    /**
     * HighLevel client instance
     * @var HighLevel
     */
    private HighLevel $client;

    /**
     * Create a new Agents resource instance
     *
     * @param HighLevel $client HighLevel client instance
     */
    public function __construct(HighLevel $client)
    {
        $this->client = $client;
    }

    /**
     * Create an Agent
     * POST /conversation-ai/agents
     *
     * @param AgentRequestDto $requestBody Request body (flexible schema)
     * @param array<string, mixed>|null $options Additional request options
     * @return AgentResponseDto
     * @throws GHLError
     * @throws GuzzleException
     */
    public function createAgent(AgentRequestDto $requestBody, ?array $options = null): AgentResponseDto
    {
        if ($requestBody !== null && is_object($requestBody) && method_exists($requestBody, 'toArray')) {
            $requestBody = $requestBody->toArray();
        }

        $requirements = ["bearer"];
        $url = RequestUtils::buildUrl('/conversation-ai/agents', []);

        $headers = array_merge(
            $options['headers'] ?? []
        );

        $authToken = RequestUtils::getAuthToken(
            $this->client,
            $requirements,
            $headers,
            [],
            $requestBody ?? null,
            $options['preferredTokenType'] ?? null
        );

        if ($authToken) {
            $headers['Authorization'] = $authToken;
        }

        $requestOptions = [
            'headers' => $headers,
            'query' => $options['query'] ?? [],
            'json' => $requestBody ?? null,
            '_security_requirements' => $requirements,
            '_path_params' => [],
            '_query_params' => $options['query'] ?? [],
        ];

        // Remove null json to match other services behavior
        if ($requestOptions['json'] === null) {
            unset($requestOptions['json']);
        }

        if ($options) {
            foreach ($options as $key => $value) {
                if (!in_array($key, ['headers', 'preferredTokenType', 'query'])) {
                    $requestOptions[$key] = $value;
                }
            }
        }

        try {
            $response = $this->client->getClient()->request('POST', $url, $requestOptions);
            $body = (string) $response->getBody();
            $responseData = json_decode($body, true) ?: [];
            return new AgentResponseDto($responseData);
        } catch (RequestException $e) {
            $statusCode = $e->hasResponse() ? $e->getResponse()->getStatusCode() : null;
            $responseBody = $e->hasResponse() ? (string) $e->getResponse()->getBody() : null;
            $responseData = $responseBody ? json_decode($responseBody, true) : null;

            throw new GHLError($e->getMessage(), $statusCode, $responseData, $requestOptions);
        }
    }

    /**
     * Search Agents
     * GET /conversation-ai/agents/search
     *
     * The query parameters are treated as flexible and passed through as-is.
     *
     * @param array<string, mixed> $params Query parameters
     * @param array<string, mixed>|null $options Additional request options
     * @return SearchAgentsResponseDto
     * @throws GHLError
     * @throws GuzzleException
     */
    public function searchAgents(array $params = [], ?array $options = null): SearchAgentsResponseDto
    {
        $requirements = ["bearer"];
        $url = RequestUtils::buildUrl('/conversation-ai/agents/search', []);

        $headers = array_merge(
            $options['headers'] ?? []
        );

        $query = array_merge($params, $options['query'] ?? []);

        $authToken = RequestUtils::getAuthToken(
            $this->client,
            $requirements,
            $headers,
            $query,
            null,
            $options['preferredTokenType'] ?? null
        );

        if ($authToken) {
            $headers['Authorization'] = $authToken;
        }

        $requestOptions = [
            'headers' => $headers,
            'query' => $query,
            '_security_requirements' => $requirements,
            '_path_params' => [],
            '_query_params' => $query,
        ];

        if ($options) {
            foreach ($options as $key => $value) {
                if (!in_array($key, ['headers', 'preferredTokenType', 'query'])) {
                    $requestOptions[$key] = $value;
                }
            }
        }

        try {
            $response = $this->client->getClient()->request('GET', $url, $requestOptions);
            $body = (string) $response->getBody();
            $responseData = json_decode($body, true) ?: [];
            return new SearchAgentsResponseDto($responseData);
        } catch (RequestException $e) {
            $statusCode = $e->hasResponse() ? $e->getResponse()->getStatusCode() : null;
            $responseBody = $e->hasResponse() ? (string) $e->getResponse()->getBody() : null;
            $responseData = $responseBody ? json_decode($responseBody, true) : null;

            throw new GHLError($e->getMessage(), $statusCode, $responseData, $requestOptions);
        }
    }

    /**
     * Update Agent
     * PUT /conversation-ai/agents/:agentId
     *
     * @param array{agentId: string} $params Path params
     * @param AgentRequestDto $requestBody Request body (flexible schema)
     * @param array<string, mixed>|null $options Additional request options
     * @return AgentResponseDto
     * @throws GHLError
     * @throws GuzzleException
     */
    public function updateAgent(array $params, AgentRequestDto $requestBody, ?array $options = null): AgentResponseDto
    {
        if ($requestBody !== null && is_object($requestBody) && method_exists($requestBody, 'toArray')) {
            $requestBody = $requestBody->toArray();
        }

        $paramDefs = [['name' => 'agentId', 'in' => 'path']];
        $extracted = RequestUtils::extractParams($params, $paramDefs);
        $requirements = ["bearer"];

        $url = RequestUtils::buildUrl('/conversation-ai/agents/{agentId}', $extracted['path']);

        $headers = array_merge(
            $extracted['header'],
            $options['headers'] ?? []
        );

        $authToken = RequestUtils::getAuthToken(
            $this->client,
            $requirements,
            $headers,
            $options['query'] ?? [],
            $requestBody ?? null,
            $options['preferredTokenType'] ?? null
        );

        if ($authToken) {
            $headers['Authorization'] = $authToken;
        }

        $query = $options['query'] ?? [];

        $requestOptions = [
            'headers' => $headers,
            'query' => $query,
            '_security_requirements' => $requirements,
            '_path_params' => $extracted['path'],
            '_query_params' => $query,
        ];

        if ($requestBody !== null) {
            $requestOptions['json'] = $requestBody;
        }

        if ($options) {
            foreach ($options as $key => $value) {
                if (!in_array($key, ['headers', 'preferredTokenType', 'query'])) {
                    $requestOptions[$key] = $value;
                }
            }
        }

        try {
            $response = $this->client->getClient()->request('PUT', $url, $requestOptions);
            $body = (string) $response->getBody();
            $responseData = json_decode($body, true) ?: [];
            return new AgentResponseDto($responseData);
        } catch (RequestException $e) {
            $statusCode = $e->hasResponse() ? $e->getResponse()->getStatusCode() : null;
            $responseBody = $e->hasResponse() ? (string) $e->getResponse()->getBody() : null;
            $responseData = $responseBody ? json_decode($responseBody, true) : null;

            throw new GHLError($e->getMessage(), $statusCode, $responseData, $requestOptions);
        }
    }

    /**
     * Get Agent
     * GET /conversation-ai/agents/:agentId
     *
     * @param array{agentId: string} $params Path params
     * @param array<string, mixed>|null $options Additional request options
     * @return AgentResponseDto
     * @throws GHLError
     * @throws GuzzleException
     */
    public function getAgent(array $params, ?array $options = null): AgentResponseDto
    {
        $paramDefs = [['name' => 'agentId', 'in' => 'path']];
        $extracted = RequestUtils::extractParams($params, $paramDefs);
        $requirements = ["bearer"];

        $url = RequestUtils::buildUrl('/conversation-ai/agents/{agentId}', $extracted['path']);

        $headers = array_merge(
            $extracted['header'],
            $options['headers'] ?? []
        );

        $query = $options['query'] ?? [];

        $authToken = RequestUtils::getAuthToken(
            $this->client,
            $requirements,
            $headers,
            $query,
            null,
            $options['preferredTokenType'] ?? null
        );

        if ($authToken) {
            $headers['Authorization'] = $authToken;
        }

        $requestOptions = [
            'headers' => $headers,
            'query' => $query,
            '_security_requirements' => $requirements,
            '_path_params' => $extracted['path'],
            '_query_params' => $query,
        ];

        if ($options) {
            foreach ($options as $key => $value) {
                if (!in_array($key, ['headers', 'preferredTokenType', 'query'])) {
                    $requestOptions[$key] = $value;
                }
            }
        }

        try {
            $response = $this->client->getClient()->request('GET', $url, $requestOptions);
            $body = (string) $response->getBody();
            $responseData = json_decode($body, true) ?: [];
            return new AgentResponseDto($responseData);
        } catch (RequestException $e) {
            $statusCode = $e->hasResponse() ? $e->getResponse()->getStatusCode() : null;
            $responseBody = $e->hasResponse() ? (string) $e->getResponse()->getBody() : null;
            $responseData = $responseBody ? json_decode($responseBody, true) : null;

            throw new GHLError($e->getMessage(), $statusCode, $responseData, $requestOptions);
        }
    }

    /**
     * Delete Agent
     * DELETE /conversation-ai/agents/:agentId
     *
     * @param array{agentId: string} $params Path params
     * @param array<string, mixed>|null $options Additional request options
     * @return DeleteAgentResponseDto
     * @throws GHLError
     * @throws GuzzleException
     */
    public function deleteAgent(array $params, ?array $options = null): DeleteAgentResponseDto
    {
        $paramDefs = [['name' => 'agentId', 'in' => 'path']];
        $extracted = RequestUtils::extractParams($params, $paramDefs);
        $requirements = ["bearer"];

        $url = RequestUtils::buildUrl('/conversation-ai/agents/{agentId}', $extracted['path']);

        $headers = array_merge(
            $extracted['header'],
            $options['headers'] ?? []
        );

        $query = $options['query'] ?? [];

        $authToken = RequestUtils::getAuthToken(
            $this->client,
            $requirements,
            $headers,
            $query,
            null,
            $options['preferredTokenType'] ?? null
        );

        if ($authToken) {
            $headers['Authorization'] = $authToken;
        }

        $requestOptions = [
            'headers' => $headers,
            'query' => $query,
            '_security_requirements' => $requirements,
            '_path_params' => $extracted['path'],
            '_query_params' => $query,
        ];

        if ($options) {
            foreach ($options as $key => $value) {
                if (!in_array($key, ['headers', 'preferredTokenType', 'query'])) {
                    $requestOptions[$key] = $value;
                }
            }
        }

        try {
            $response = $this->client->getClient()->request('DELETE', $url, $requestOptions);
            $body = (string) $response->getBody();
            $responseData = $body !== '' ? (json_decode($body, true) ?: []) : [];
            return new DeleteAgentResponseDto($responseData);
        } catch (RequestException $e) {
            $statusCode = $e->hasResponse() ? $e->getResponse()->getStatusCode() : null;
            $responseBody = $e->hasResponse() ? (string) $e->getResponse()->getBody() : null;
            $responseData = $responseBody ? json_decode($responseBody, true) : null;

            throw new GHLError($e->getMessage(), $statusCode, $responseData, $requestOptions);
        }
    }
}

