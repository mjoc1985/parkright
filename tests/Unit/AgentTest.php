<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AgentTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_new_agent_and_retrieve_from_database()
    {
        $data = ['name' => 'test_agent', 'slug' => 'test_agent', 'email' => 'test_agent@email.com'];

        $agent = $this->postJson('/api/agents', $data);

        $agent->assertStatus(201);

        $getAgent = json_decode($this->getJson('/api/agents/1/edit')->getContent());

        $this->assertEquals('test_agent', $getAgent->name);
    }

    public function test_can_list_all_agents()
    {
        $data = [
            ['name' => 'test_agent_one', 'slug' => 'test_agent_one', 'email' => 'test_agent_one@email.com'],
            ['name' => 'test_agent_two', 'slug' => 'test_agent_two', 'email' => 'test_agent_two@email.com'],
            ['name' => 'test_agent_three', 'slug' => 'test_agent_three', 'email' => 'test_agent_three@email.com']
        ];

        foreach ($data as $item) {
            $this->postJson('/api/agents', $item)->assertStatus(201);
        }

        $agents = json_decode($this->getJson('/api/agents')->getContent());

        $this->assertCount(3, $agents);

    }

    public function test_can_update_agent()
    {
        $data = ['name' => 'test_agent', 'slug' => 'test_agent', 'email' => 'test_agent@email.com'];

        $this->postJson('/api/agents', $data)->assertStatus(201);

        $this->patchJson('/api/agents/5/update', ['name' => 'updated_name'])->assertStatus(200);

        $updated = json_decode($this->getJson('/api/agents/5/edit')->getContent());

        $this->assertEquals('updated_name', $updated->name);
    }


}
