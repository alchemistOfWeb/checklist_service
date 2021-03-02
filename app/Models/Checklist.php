<?php

namespace App\Models;

use App\Exceptions\Handler;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Traits\OptionsJsonField;

class Checklist extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description'];

    protected $casts = [
        'options' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    /**
     * Create a new checklist.
     * @param $fields 
     * {
     *  title: string,
     *  options: array,
     * }
     * @return Checklist
     */
    public static function create($fields)
    {        
        $user = auth()->user();
        // $user->increment('num_of_checklists');
        // $user->save();

        $checklist = new static;
        $checklist->fill($fields);
        
        // $checklist->options = static->validateOptions($checklist, $fields['options']);

        $checklist->user_id = $user->id;
        $checklist->save();
        
        return $checklist;
    }


    /**
     * Create a new checklist.
     * @param $fields 
     * {
     *  title: string,
     *  options: array,
     * }
     */
    public function edit($fields)
    {
        $this->fill($fields);
        $this->save();
    }

    

    public function remove() 
    {
        $this->delete();
        
        $user = $this->user;
        $user->num_of_checklists -= 1;
        $user->save();
    }
}