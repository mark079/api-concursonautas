<?php

namespace Tests\Unit;

use App\Models\StudyBlock;
use Carbon\Carbon;
use Tests\TestCase;

class ApiTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testCreateGoal()
    {
        $type = ['C','V'];

        $test_name = [
            'C' => ['PRF', 'Receita Federal', 'Banco Central'],
            'V' => ['ENEM', 'USP', 'Unicamp']
        ];

        $randomType = $type[array_rand($type)];
        $randomContent = $test_name[$randomType][array_rand($test_name[$randomType])];

        $today = Carbon::now();

        $goalData = [
            'user_id' => 1,
            'type' => $randomType,
            'test_date' => Carbon::parse($today->addWeeks(2))->format('Y-m-d'),
            // 'content_to_study' => $randomContent
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
        $scheduleData = [
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

        $response = $this->withHeaders($headers)->json('POST', '/api/v1/schedules', $scheduleData);
        $response->assertStatus(201);

        $this->assertDatabaseHas('schedules', $scheduleData[0]);
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

    /**
     * @depends testCreateGoal
     */
    public function testUpdateStudyBlock($goalId)
    {
        $studyBlockData = [
            "completed" => 1
        ];

        $id = StudyBlock::where('goal_id', '=', $goalId)->get()->random()->id;

        $response = $this->json('PUT', "/api/v1/study-blocks/$id/atualizar", $studyBlockData);
        $response->assertStatus(200);
        $this->assertDatabaseHas('study_blocks', $studyBlockData);
    }

    /**
     * @depends testCreateGoal
     */
    public function testDeleteGoal($goalId)
    {
        $response = $this->json('DELETE', "/api/v1/goals/$goalId");
        $response->assertStatus(200);
    }
}
