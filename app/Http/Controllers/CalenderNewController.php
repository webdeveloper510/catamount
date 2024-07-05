<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Meeting;
use App\Models\Blockdate;

class CalenderNewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blockeddate = Blockdate::all();
        return view('calender_new.index', compact('blockeddate'));
    }
    public function get_event_data(Request $request)
    {
        $events = Meeting::where('start_date', $request->start)->get();
        return response()->json(["events" => $events]);
    }
    public function blockeddateinfo()
    {
        $block = Blockdate::all();
        return $block;
    }
    public function eventinfo()
    {
        if (\Auth::user()->type != 'owner') {
            $crnt_user = \Auth::user()->id;
            $event = Meeting::orderBy('id', 'desc')->get()->filter(function ($meeting) use ($crnt_user) {
                $user_data = json_decode($meeting->user_data, true);
                if (isset($user_data[$crnt_user])) {
                    return true;
                }
                return false;
            });
        } else {
            $event = Meeting::all();
        }

        $event = array_values($event->toArray());
        return $event;
    }
    public function monthbaseddata(Request $request)
    {
        $startDate = "{$request->year}-{$request->month}-01";
        $endDate = date('Y-m-t', strtotime($startDate));
        if (\Auth::user()->type != 'owner') {
            $crnt_user = \Auth::user()->id;
            $crnt_userName = \Auth::user()->name;
            $data = Meeting::whereBetween('start_date', [$startDate, $endDate])->get()->filter(function ($meeting) use ($crnt_user, $crnt_userName) {
                $user_data = json_decode($meeting->user_data, true);
                // $meeting->calenderData = $user_data[$crnt_user]['amount'];
                if (isset($user_data[$crnt_user])) {
                    $meeting->calenderData = "{$crnt_userName} - &dollar;{$user_data[$crnt_user]['amount']}";
                    return $meeting;
                }
                return false;
            });
        } else {
            $data = Meeting::whereBetween('start_date', [$startDate, $endDate])->get()->map(function ($mapMeeting) {
                $user_data = json_decode($mapMeeting->user_data);

                foreach ($user_data as $udKey => $udValue) {
                    $trainerName = \App\Models\User::find($udKey)->name;
                    $user_datas[] = "{$trainerName} - &dollar;{$udValue->amount}";
                }
                $user_datas = implode(", ", $user_datas);
                $mapMeeting->calenderData = $user_datas;
                return $mapMeeting;
            });
        }
        $data = array_values($data->toArray());
        return $data;
    }
    public function weekbaseddata(Request $request)
    {
        $startDate = $request->startdate;
        $endDate = $request->enddate;
        $data = Meeting::whereBetween('start_date', [$startDate, $endDate])->get();
        return $data;
        print_r($request->all());
    }
    public function daybaseddata(Request $request)
    {
        $startDate = $request->date;
        $data = Meeting::where('start_date', $startDate)->get();
        return $data;
        print_r($request->all());
    }
}
