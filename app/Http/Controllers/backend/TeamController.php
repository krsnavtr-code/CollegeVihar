<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    static function createTeam(Request $request)
    {
        $team = new Team;

        $team->team_leader = $request->team_leader;
        $team->team_name = $request->team_name;
        $r = $team->save();
        if($r){
            $teamId = $team->id;
            foreach ($request->team_members as $member) {
                $member = Employee::find($member);
                if ($member->emp_team != 1)
                $member['emp_team'] = $teamId;
                $member->save();
            }
        }
        return ["success" => $r];
    }
}
