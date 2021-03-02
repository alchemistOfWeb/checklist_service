<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Checklist;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{

    /**
     * get tasks that belongs to checklist with $cid.
     * 
     * @param $cid - checklist id where we get tasks from
     *
     * @return \Illuminate\Http\Response
     */
    public function index($cid)
    {
        $checklist = Checklist::find($cid);

        $this->authorizeForUser(auth()->user(), 'is-checklist-owner', $checklist);

        $tasks = $checklist->tasks;

        return response()->json($tasks, 200);
    }

    /**
     * switch on the task if it's switched off and switch off in another case.
     * 
     * @param $cid - checklist id where we toggle the task
     * @param $tid - task id that will be toggled
     * 
     * @return \Illuminate\Http\Response
     */
    public function toggleStatus($cid, $tid)
    {
        $checklist = Checklist::find($cid);

        $this->authorizeForUser(auth()->user(), 'is-checklist-owner', $checklist);

        $checklist->tasks()->find($tid)->toggleStatus();

        return response()->json('', 200);
    }

    /**
     * add new task into the checklist.
     * 
     * @param $cid - checklist id where we add the task
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function create($cid, Request $request)
    {
        $checklist = Checklist::find($cid);

        $this->authorizeForUser(auth()->user(), 'is-checklist-owner', $checklist);

        $task = $checklist->tasks()->create($request->only('text'));
        
        return response()->json($task, 201);
    }

    /**
     * delete task.
     *
     * @param $cid - checklist id where we delete the task
     * @param $tid - task id that will be deleted
     * 
     * @return \Illuminate\Http\Response
     */
    public function destroy($cid, $tid)
    {
        $checklist = Checklist::find($cid);

        $this->authorizeForUser(auth()->user(), 'is-checklist-owner', $checklist);

        $checklist->deleteTask($tid);

        return response()->json('', 204);
    }
}