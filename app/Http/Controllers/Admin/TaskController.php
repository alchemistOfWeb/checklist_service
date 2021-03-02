<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Checklist;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index($uid, $cid)
    {
        $checklist = Checklist::find($cid);
        $tasks = $checklist->tasks()->paginate(15);

        return view('admin.tasks.index',[
            'checklist' => $checklist,
            'tasks' => $tasks,
        ]);
    }
}
