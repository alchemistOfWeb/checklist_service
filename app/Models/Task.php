<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    const IS_DONE = 1;
    const ISNT_DONE = 0;

    protected $fillable = ['text'];

    public function checklist()
    {
        return $this->belongsTo(Checklist::class);
    }

    static function create($fields)
    {
        $task = new static;
        $task->text = $fields['text'];
    }

    public function isDone()
    {
        return $this->status == static::IS_DONE;
    }
    
}
