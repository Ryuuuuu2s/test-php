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

        $response = $this->postJson(route('todo.store'), $incompleteData);

        $response->assertStatus(422);
    }
    

    /**
     * @test
     */
    public function 更新処理(): void
    {

        $initialData = [
            'title' => '初期タイトル',
            'content' => '初期内容',
        ];

        $todo = Todo::factory()->create($initialData);

        $updateData = [
            'title' => '更新後のタイトル',
            'content' => '更新後の内容',
        ];

        $response = $this->putJson(route('api.todo.update', ['id' => $todo->id]), $updateData);

        $response->assertStatus(200);

        $this->assertDatabaseHas('todos', [
            'id' => $todo->id,
            'title' => $updateData['title'],
            'content' => $updateData['content'],
        ]);
    }


    /**
     * @test
     */
    public function 更新処理の未入力(): void
    {
        $initialData = [
            'title' => '初期タイトル',
            'content' => '初期内容',
        ];

        $todo = Todo::factory()->create($initialData);

        $updateData = [
            'title' => '',
            'content' => '',
        ];

        $response = $this->putJson(route('api.todo.update', ['id' => $todo->id]), $updateData);

        $response->assertStatus(422);

        $this->assertDatabaseHas('todos', $initialData);
    }


    /**
     * @test
     */
    public function 存在しないレコードの更新処理(): void
    {

        $nonExistentId = Todo::max('id') + 1;

        $updateData = [
            'title' => '更新タイトル',
            'content' => '更新内容',
        ];

        $response = $this->putJson(route('api.todo.update', ['id' => $nonExistentId]), $updateData);

        $response->assertStatus(404);
    }

    /**
     * @test
     */
    public function 存在する詳細取得(): void
    {

        $todoData = [
            'title' => '存在するタイトル',
            'content' => '存在する内容',
        ];

        $todo = Todo::factory()->create($todoData);

        $response = $this->get(route('api.todo.show', ['id' => $todo->id]));

        $response->assertStatus(200);

        $response->assertJson([
            'id' => $todo->id,
            'title' => $todoData['title'],
            'content' => $todoData['content'],
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
        $todoData = [
            'title' => '存在するタイトル',
            'content' => '存在する内容',
        ];

        $todo = Todo::factory()->create($todoData);

        $response = $this->deleteJson(route('api.todo.delete', ['id' => $todo->id]));

        $response->assertStatus(200);

        $this->assertDatabaseMissing('todos', [
            'id' => $todo->id,
            'title' => $todoData['title'],
            'content' => $todoData['content'],
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