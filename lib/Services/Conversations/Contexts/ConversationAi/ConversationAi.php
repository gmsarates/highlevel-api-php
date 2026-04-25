<?php

namespace HighLevel\Services\Conversations\Contexts\ConversationAi;

use HighLevel\HighLevel;

/**
 * ConversationAi context (Conversation AI / AI Employees API)
 *
 * This context groups Conversation AI endpoints under Conversations and leaves
 * space for additional resources (e.g. Actions, Generations) in the future.
 *
 * @package HighLevel\Services\Conversations\Contexts\ConversationAi
 */
class ConversationAi
{
    /**
     * Agents resource
     * @var Agents
     */
    public Agents $agents;

    /**
     * Create a new ConversationAi context instance
     *
     * @param HighLevel $client HighLevel client instance
     */
    public function __construct(HighLevel $client)
    {
        $this->agents = new Agents($client);
    }
}

