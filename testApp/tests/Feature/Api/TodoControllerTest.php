<?php

namespace Tests\Feature\Api;

use App\Models\Todo;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TodoControllerTest extends TestCase
{
    use DatabaseTransactions;

    public function setUp():void
    {
        parent::setUp();
    }

    /**
     * @test
     */
    public function Todoの新規作成()
    {
        $params = [
            'title' => 'テスト:タイトル',
            'content' => 'テスト:内容'
        ];

        $res = $this->postJson(route('api.todo.create'), $params);
        $res->assertOk();
        $todos = Todo::all();

        $this->assertCount(1, $todos);

        $todo = $todos->first();

        $this->assertEquals($params['title'], $todo->title);
        $this->assertEquals($params['content'], $todo->content);

    }

     /**
     * @test
     */
    public function 新規作成の未入力(): void
    {
        $incompleteData = [
            'title' => '', 
            'content' => '',
        ];

        $response = $this->postJson('/todo', $incompleteData);

        $response->assertStatus(422);
    }
    

    /**
     * @test
     */
    public function 更新処理(): void
    {

        $todo = Todo::create([
            'title' => '初期タイトル',
            'content' => '初期内容',
        ]);

        $updateData = [
            'title' => '更新後のタイトル',
            'content' => '更新後の内容',
        ];

        $response = $this->putJson('/todo/' . $todo->id, $updateData);

        $response->assertStatus(302);

        $this->assertDatabaseHas('todos', [
            'id' => $todo->id,
            'title' => '更新後のタイトル',
            'content' => '更新後の内容',
        ]);
    }

    /**
     * @test
     */
    public function 更新処理の未入力(): void
    {

        $updateData = [
            'title' => '',
            'content' => '',
        ];

        $response = $this->putJson('/todo/1', $updateData);

        $response->assertStatus(422);
    }

    
    /**
     * @test
     */
    public function 存在する詳細取得(): void
    {

        $todo = Todo::create([
            'title' => '存在するタイトル',
            'content' => '存在する内容',
        ]);

        $response = $this->get('/api/todo/' . $todo->id);

        $response->assertStatus(200);

        $response->assertJson([
            'id' => $todo->id,
            'title' => '存在するタイトル',
            'content' => '存在する内容',
        ]);
    }
        
    /**
     * @test
     */
    public function 存在しない詳細取得(): void
    {

        $response = $this->get('/api/todo/1000');

        $response->assertStatus(404);
    }

    /**
     * @test
     */
    public function 存在する削除処理(): void
    {
        $todo = Todo::create([
            'title' => '削除するタイトル',
            'content' => '削除する内容',
        ]);

        $response = $this->delete('/todo/delete/' . $todo->id);

        $response->assertStatus(200);

        $this->assertDatabaseMissing('todos', [
            'id' => $todo->id,
            'title' => '削除するタイトル',
            'content' => '削除する内容',
        ]);
    }   
    
    /**
     * @test
     */
    public function 存在しない削除処理(): void
    {

            $response = $this->delete('/todo/delete/1000');

            $response->assertStatus(404);
    }
}