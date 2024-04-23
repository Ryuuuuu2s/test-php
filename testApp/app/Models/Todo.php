<?php
declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
* Todo class
*/
class Todo extends Model
{

    /**
    * @var array
    */
    protected $fillable = ['title', 'content'];

    /**
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];
    

    use HasFactory;

    protected static function newFactory(){

        return \Database\Factories\TodoFactory::new();

    }

    public function show(Todo $todo)
    {
        return response()->json($todo);
    }
}

