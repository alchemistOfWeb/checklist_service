<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Checklist;
use App\Models\User;
use Illuminate\Http\Request;

class ChecklistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getChecklists($uid)
    {
        return 
            response()->json(
                Checklist::where('user_id', $uid)
                    ->get(['id', 'description', 'title']), 
                200
            );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getTasks($uid, $cid)
    {
        $checklist = Checklist::find($cid);
        return response()->json($checklist->options, 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function toggleTask($uid, $cid, $tid)
    {
        Checklist::find($cid)->toggleTask($tid);
        return response()->json('', 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createTask($uid, $cid, Request $request)
    {
        Checklist::find($cid)->createTask($request->all());
        return response()->json('', 201);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroyTask($uid, $cid, $tid)
    {
        Checklist::find($cid)->deleteTask($tid);
        return response()->json('', 204);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function createChecklist($uid, Request $request)
    {
        // $checklist = Checklist::create($request->all());
        // return response()->json($checklist, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyChecklist($uid, $cid)
    {
        Checklist::find($cid)->remove();
        return response()->json('', 204);
    }
}
