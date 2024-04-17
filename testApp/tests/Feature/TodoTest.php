<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TodoTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        // 元のコード
        // $response = $this->get('/');
        // $response->assertStatus(200);


        // 不十分なデータでPOSTリクエストを送信
        $incompleteData = [
            // 空のデータだった場合
            'title' => '', 
            'content' => '',
        ];

        $response = $this->postJson('/todo', $incompleteData);

        // ステータスコード 422 
        $response->assertStatus(422);
    }
    

    // 更新処理
    public function test_update(): void
    {
        // 更新するデータが空の場合
        $updateData = [
            'title' => '',
            'content' => '',
        ];

        // 更新するデータを送信
        $response = $this->putJson('/todo/1', $updateData);

        // ステータスコード 422
        $response->assertStatus(422);
    }

    // 詳細取得
    public function test_show(): void
    {
        // 存在しないIDを指定してリクエストを送信
        $response = $this->get('/api/todo/1000');

        // ステータスコード 404 Not Found を期待
        $response->assertStatus(404);
    }

    // 削除処理
    public function test_destroy(): void
    {
            // 存在しないIDを指定
            $response = $this->delete('/todo/delete/1000');

            // ステータスコード 404 を期待
            $response->assertStatus(404);
    }
    
}
