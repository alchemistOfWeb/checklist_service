<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Checklist;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ChecklistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($uid)
    {
        return 
            response()->json(
                Checklist::where('user_id', $uid)
                    ->get(['id', 'description', 'title']), 
                200
            );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create($uid, Request $request)
    {
        $validator = Validator::make($request, [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['string', 'max:500'],
            // 'options' => ['array'],
        ]);
        
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $user = $request->user();

        if ( $user->num_of_checklists >= $user->limit_of_checklists ) {
            return response()->json(['error' => "limit of checklists is exceeded"], 403);
        }

        $checklist = Checklist::create($request->only('title', 'description'));
        // $checklist = Checklist::create($request->only('title', 'description', 'options'));
        
        return response()->json($checklist, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($uid, $cid)
    {
        Checklist::find($cid)->remove();
        return response()->json('', 204);
    }
}
