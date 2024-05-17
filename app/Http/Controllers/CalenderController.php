<?php

namespace App\Http\Controllers;

use App\Models\Call;
use App\Models\Meeting;
use App\Models\Task;
use App\Models\Utility;
use App\Models\Blockdate;
use App\Models\User;
use App\Models\Lead;
use DateTime;
use DatePeriod;
use DateInterval;



use Illuminate\Http\Request;

class CalenderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transdate = date('Y-m-d', time());
        $blockeddate = Blockdate::all();

        if (\Auth::user()->type == 'owner') {
            $calls    = Call::where('created_by', \Auth::user()->creatorId())->get();
            $meetings = Meeting::where('created_by', \Auth::user()->creatorId())->get();
            $tasks    = Task::where('created_by', \Auth::user()->creatorId())->get();
        } else {
            $calls    = Call::where('user_id', \Auth::user()->id)->get();
            $meetings = Meeting::where('user_id', \Auth::user()->id)->get();
            $tasks    = Task::where('user_id', \Auth::user()->id)->get();
        }
        return view('calendar.index', compact('transdate', 'blockeddate'));
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
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function calendar()
    {
    }
    public function get_data(Request $request)
    {

        $arrMeeting = [];
        $arrTask    = [];
        $arrCall    = [];
        $arrblock   = [];

        if ($request->get('calender_type') == 'goggle_calender') {
            if ($type = 'task') {
                $arrTask =  Utility::getCalendarData($type);
            }

            if ($type = 'meeting') {
                $arrMeeting =  Utility::getCalendarData($type);
            }

            if ($type = 'call') {
                $arrCall =  Utility::getCalendarData($type);
            }

            $arrayJson = array_merge($arrCall, $arrMeeting, $arrTask);
        } else {

            $arrMeeting = [];
            $arrTask    = [];
            $arrCall    = [];
            $arrblock   = [];

            $meetings = Meeting::all();
            $blockeddate = Blockdate::all();
            
            //22-01-2024
            foreach ($meetings as $val) {
                $end_date = date_create($val->end_date);
                $leadname = Lead::where('id', $val->attendees_lead)->pluck('leadname')->first();
                $blockingUser = $val->user ?? null;
                $blockingUserName = $blockingUser ? $blockingUser->name : 'Unknown User';

                $now = new DateTime();
                $backgroundColor = ($end_date > $now) ? 'green' : 'red';
                $expireDate = date('Y-m-d', strtotime($val->end_date . ' + 1 days'));
                $arrMeeting[] = [
                    "id" => $val->id,
                    "title" => $leadname,
                    "start" => $val->start_date,
                    "end" =>  $expireDate,
                    "className" => $val->color,
                    "textColor" => '#fff',
                    "url" => route('meeting.show', $val['id']),
                    "allDay" => true,
                    "blocked_by" => $blockingUserName, 
                    "backgroundColor" => $backgroundColor,
                ];
            }

            foreach ($blockeddate as $val) {
                $blockingUser = $val->user ?? null;
                $blockingUserName = $blockingUser ? $blockingUser->name : 'Unknown User';

                $expireDate = date('Y-m-d', strtotime($val->end_date . ' + 1 days'));

                $uniqueId = $val->unique_id;

                $arrblock[] = [
                    "id" => $val->id,
                    "title" => $val->purpose,
                    "start" => $val->start_date,
                    "end" => $expireDate,
                    "className" => $val->color,
                    "textColor" => '#fff',
                    "allDay" => true,
                    // "display" => 'background',
                    "url" => url('/show-blocked-date-popup' . '/' . $val->id),
                    "backgroundColor" => "grey",
                    "blocked_by" => $blockingUserName, 
                    "unique_id" => $uniqueId,
                ];
            }

            $arrayJson = array_merge($arrMeeting, $arrblock);
        }
        return $arrayJson;
    }
    //22-01-2024
    public function show_blocked_date_popup($id)
    {
        $user_data = Blockdate::where('id', $id)->first();
        if ($user_data) {
            $blocked_by_id = $user_data->created_by;
            $blocked_username = User::where('id', $blocked_by_id)->value('name');
            return view('calendar.view', compact('user_data', 'blocked_username'));
        }
    }

    public function unblock_this_date($id){
        $blockDate = Blockdate::find($id);
        $blockeddate = Blockdate::all();
            if ($blockDate) {
                $blockDate->delete();
                return view('calender_new.index',compact('blockeddate'))->with('success', 'Date Unblocked');
            }
    }
   
}