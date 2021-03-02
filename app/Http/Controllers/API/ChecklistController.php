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
    public function index()
    {
        $checklists = auth()->user()->checklists;

        return response()->json($checklists, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['string', 'max:500'],
        ]);
        
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $user = $request->user();

        if ( $user->num_of_checklists >= $user->limit_of_checklists ) {
            return response()->json(['error' => "limit of checklists is exceeded"], 403);
        }

        $checklist = Checklist::create($request->only('title', 'description'));
        
        return response()->json($checklist, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($cid)
    {
        $checklist = Checklist::find($cid);

        $this->authorizeForUser(auth()->user(), 'is-checklist-owner', $checklist);

        $checklist->remove();

        return response()->json('', 204);
    }
}
