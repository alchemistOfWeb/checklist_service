<?php

namespace App\Models;

use App\Exceptions\Handler;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Checklist extends Model
{
    use HasFactory;

    const TASK_IS_DONE = 1;
    const TASK_ISNT_DONE = 0;

    protected $table = "checklists";

    protected $fillable = ['title', 'options'];

    protected $casts = [
        'options' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
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
    public static function create($uid, $fields)
    {

        
        // if ($user->num_of_checklists >= $user->limit_of_checklists) {
        //     abort(403, 'limit is exceeded');
        // }
        $user = Auth::guard('user')->user();
        $uid = $user->id;
        
        $checklist = new static;
        $user = $checklist->user;
        $checklist->fill($fields);
        $checklist->user_id = $uid;
        $checklist->save();


        $user->num_of_checklists++;
        $user->save();
        
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

    /**
     * @param array $task 
     * {
     *  text: string,
     *  is_done: int/true, 
     * }
     * 
     */
    public function createTask(array $task) 
    {
        $tasks = $this->options;
        array_column($tasks, 'tid');


        $tasks[] = [
            'tid' => $this->task_increment++,
            'title' => $task['title'],
            'is_done' => 0,
        ];
        // $this->task_increment++;

        $this->options = $tasks;
        $this->save();
    }
    
    /**
     * remove the task of the checklist
     * @param $taskIndex
     */
    public function deleteTask($taskId)
    {
        $tasks = $this->options;
        $key = array_search($taskId, array_column($tasks, 'tid'));
        array_splice($tasks, $key, 1);
        $this->options = $tasks;
        $this->save();
    }

    /**
     * switch on the checklist item to mark it was done
     * @param $taskIndex
     */
    public function switchOnTask($taskId)
    {
        $options = $this->options;
        $key = array_search($taskId, array_column($options, 'tid'));
        $options[$key]['is_done'] = true;
        $this->options = $options;
        $this->save();
    }

    /**
     * switch off the checklist item to mark it wasn't actually done
     * @param $taskIndex
     */
    public function switchOffTask($taskId)
    {
        $options = $this->options;
        $key = array_search($taskId, array_column($options, 'tid'));
        $options[$key]['is_done'] = false;
        $this->options = $options;
        $this->save();
    }

    /**
     * @param $taskIndex
     */
    public function toggleTask($taskId)
    {
        $options = $this->options;

        $key = array_search($taskId, array_column($options, 'tid'));

        if ($options[$key]['is_done'] == self::TASK_IS_DONE) {
            $options[$key]['is_done'] = self::TASK_ISNT_DONE;
        } else {
            $options[$key]['is_done'] = self::TASK_IS_DONE;    
        }
        
        $this->options = $options;
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
