<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Models\Todo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TodoController extends Controller
{
    private Todo $todo;

    public function __construct(Todo $todo)
    {
        $this->todo = $todo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $todos = $this->todo->orderby('updated_at', 'desc')->paginate(5);
        return $todos;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string', 'max:255']
        ]);
        $this->todo->fill($validated)->save();

        return ['message' => 'ok'];
    }

    public function show(int $id)
    {

        // 元
        $todo = $this->todo->findOrFail($id);

        return $todo;

        // 追加
        // $todo = Todo::findOrFail($id);
        // return response()->json($todo, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $todo = $this->todo->findOrFail($id);

        return $todo;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        // 元
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string', 'max:255']
        ]);
        $todo = $this->todo->findOrFail($id);

        $todo->update($validated);

        return $todo;

        // 追加
        // $validated = $request->validate([
        //     'title' => 'required|string|max:255',
        //     'content' => 'required|string|max:255',
        // ]);
    
        // $todo = Todo::findOrFail($id);
        // $todo->update($validated);
    
        // return response()->json($todo, 200);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        // 元
        $this->todo->findOrFail($id)->delete();
        return ['message' => 'ok'];


        // 追加
        // $todo = Todo::findOrFail($id);
        // $todo->delete();

        // return response()->json(null, 204);
    }
}