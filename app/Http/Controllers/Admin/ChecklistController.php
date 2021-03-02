<?php

namespace App\Http\Controllers\Admin;

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
    public function index($user_id)
    {
        $checklists = Checklist::where('user_id', $user_id)->paginate(15);

        $user = User::find($user_id);

        $checklists = $user->checklists()->paginate(15);

        return view('admin.checklists.index', [
            'checklists' => $checklists,
            'user_id'    => $user_id,
            'user'       => $user,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show($uid, $cid)
    // {
    //     $checklist = Checklist::find($cid);

    //     if ($checklist->user_id != $uid) {
    //         abort(404);
    //     } 
        
    //     return view(
    //         'admin.checklists.show', 
    //         [
    //             'checklist' => $checklist,
    //         ]
    //     );
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($uid, $id)
    {
        $this->authorizeForUser(auth('admin')->user(), 'delete', Checklist::class);

        Checklist::find($id)->delete();
    }
}
