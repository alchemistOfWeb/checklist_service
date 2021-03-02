<?php

namespace App\Traits;

trait OptionsJsonField
{
    const TASK_IS_DONE = 1;
    const TASK_ISNT_DONE = 0;

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

    public function validateOptions($checklist, $options_field) {
        return array_map(function($item) use($checklist){
            if (!isset($item['title'])) {
                return;
            }

            return [
                'tid' => $checklist->task_increment,
                'title' => $item['title'],
                'is_done' => self::TASK_ISNT_DONE,
            ];
        }, $options_field);
    }
}