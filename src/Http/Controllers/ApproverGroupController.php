<?php

namespace Httpfactory\Approvals\Http\Controllers;

use Httpfactory\Approvals\Models\User;
use Illuminate\Http\Request;
use Httpfactory\Approvals\Contracts\ApproverGroupRepository as Approver;
use Httpfactory\Approvals\Traits\HasTeam;

class ApproverGroupController extends Controller
{
    use HasTeam;

    public $approverGroup;

    public function __construct(Approver $approverGroup)
    {
        $this->approverGroup = $approverGroup;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //show a list view of all groups if needed.
        return redirect('/group/create');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('approvals::approvals.groups.create-group');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $teamId = $this->hasTeam();
        $data = $request->all(); //get all inputs from form...
        $group = $this->approverGroup->create($data, $teamId);

        //return some re-direct response...
        return redirect('/group/create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
//        $group = $this->approverGroup->getById($id);
//        return view('approvals::approvals.groups.update-group', ['group', $group]);

        $route = '/group/' . $id . '/edit';
        return redirect($route);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $group = $this->approverGroup->getById($id);
        abort_unless($group, 404);
        return view('approvals::approvals.groups.update-group', ['group' => $group]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all(); //get all inputs from form...
        $group = $this->approverGroup->update($data, $id);

        //return some re-direct response...
        return redirect('/group/' . $id . '/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    /**
     * Handles attaching users to an approver group
     *
     * @param Request $request
     */
    public function attach(Request $request)
    {
        //an array of user objects to attach....
        //then do $this->approverGroup->attach();
//        $groupId = 1;
//        $users = [
//            new User,
//            new User
//        ];
//        $this->approverGroup->attachUsers($groupId, $users, $this->hasTeam());
    }


    /**
     * Handles attaching users to an approver group
     *
     * @param Request $request
     */
    public function detach(Request $request)
    {

    }

}
