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
     * @param $uid - user id
     * @param $cid - checklist id where we get tasks from
     *
     * @return \Illuminate\Http\Response
     */
    public function index($uid, $cid)
    {
        $checklist = Checklist::find($cid);
        return response()->json($checklist->options, 200);
    }

    /**
     * switch on the task if it's switched off and switch off in another case.
     * 
     * @param $uid - user id
     * @param $cid - checklist id where we toggle the task
     * @param $tid - task id that will be toggled
     * 
     * @return \Illuminate\Http\Response
     */
    public function toggleStatus($uid, $cid, $tid)
    {
        // Checklist::find($cid)->toggleTask($tid);

        Task::find($tid)->toggleStatus();
        return response()->json('', 200);   
    }

    /**
     * add new task into the checklist.
     * @param $uid - user id
     * @param $cid - checklist id where we add the task
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function create($uid, $cid, Request $request)
    {
        // Checklist::find($cid)->createTask($request->only('text'));

        Task::create($request->text);
        
        return response()->json('', 201);
    }

    /**
     * delete task.
     *
     * @param $uid - user id
     * @param $cid - checklist id where we delete the task
     * @param $tid - task id that will be deleted
     * 
     * @return \Illuminate\Http\Response
     */
    public function destroy($uid, $cid, $tid)
    {
        Checklist::find($cid)->deleteTask($tid);
        return response()->json('', 204);
    }
}