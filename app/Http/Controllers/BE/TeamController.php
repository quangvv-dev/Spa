<?php

namespace App\Http\Controllers\BE;

use App\Constants\StatusCode;
use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\TeamMember;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Team::when(isset($request->name), function ($q) use ($request) {
            return $q->where('name', 'like', '%' . $request->name . '%');
        })->orderBy('id', 'desc')->paginate(StatusCode::PAGINATE_20);
        if ($request->ajax()) {
            return view('team.ajax', compact('data'));
        }
        return view('team.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->except('user_id');
        $team = Team::create($data);
        // insert team member
        if (isset($request->user_id) && count($request->user_id)) {
            foreach ($request->user_id as $item) {
                TeamMember::create([
                    'user_id' => $item,
                    'team_id' => $team->id
                ]);
            }
        }
        return back()->with('success', 'Thêm nhóm thành công');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function show(Team $team)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function edit(Team $team)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Team $team)
    {
        TeamMember::where('team_id', $team->id)->delete();

        if (isset($request->user_id) && count($request->user_id)) {
            foreach ($request->user_id as $item) {
                TeamMember::create([
                    'user_id' => $item,
                    'team_id' => $team->id
                ]);
            }
        }
        $team->update($request->except('user_id'));
        return back()->with('success', 'Cập nhật nhóm thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function destroy(Team $team)
    {
        TeamMember::where('team_id', $team->id)->delete();
        $team->delete();
        return 1;
    }
}
