<?php

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;

class ApiTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testCreateGoal()
    {
        $type = [
            ['key' => 'C', 'value' => 'Concurso'],
            ['key' => 'V', 'value' => 'Vestibular']
        ];

        $content_to_study = [
            'C' => ['PRF', 'Receita Federal', 'Banco Central'],
            'V' => ['ENEM', 'USP', 'Unicamp']
        ];

        $randomType = $type[array_rand($type)]['key'];
        $randomContent = $content_to_study[$randomType][array_rand($content_to_study[$randomType])];

        $today = Carbon::now();

        $goalData = [
            'user_id' => 1,
            'type' => $randomType,
            'test_date' => Carbon::parse($today->addWeeks(2))->format('Y-m-d'),
            'content_to_study' => $randomContent
        ];

        $response = $this->json('POST', '/api/v1/goals', $goalData);
        $response->assertStatus(201);
        $content = $response->decodeResponseJson();
        $goalId = $content['data']['id'];

        return $goalId;
    }

    /**
     * @depends testCreateGoal
     */
    public function testCreateSchedule($goalId)
    {
        $goalData = [
            [
                "user_id" => 1,
                "goal_id" => $goalId,
                "weekday" => 1,
                "start_time" => Carbon::parse('09:00')->format('H:i')
            ],
            [
                "user_id" => 1,
                "goal_id" => $goalId,
                "weekday" => 5,
                "start_time" => Carbon::parse('07:45')->format('H:i')
            ]
        ];

        $headers = ['Content-Type' => 'application/json'];

        $response = $this->withHeaders($headers)->json('POST', '/api/v1/schedules', $goalData);
        $response->assertStatus(201);

        $this->assertDatabaseHas('schedules', $goalData[0]);
    }

    /**
     * @depends testCreateGoal
     */
    public function testCreateStudyBlock($goalId)
    {
        $studyBlockData = [
            "goal_id" => $goalId,
        ];

        $response = $this->json('POST', '/api/v1/study-blocks', $studyBlockData);
        $response->assertStatus(201);

        $this->assertDatabaseHas('study_blocks', $studyBlockData);
    }
}