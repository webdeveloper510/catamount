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
        return view('calender_new.index',compact('blockeddate'));
    }
    public function get_event_data(Request $request)
    {
        $events = Meeting::where('start_date', $request->start)->get();
        return response()->json(["events" => $events]);
    }
    public function blockeddateinfo(){
        $block = Blockdate::all();
        return $block;
    }
    public function eventinfo(){
        $event = Meeting::all();
        return $event;
       
    }
    public function monthbaseddata(Request $request){
       
        $startDate = "{$request->year}-{$request->month}-01"; // First day of the month
        $endDate = date('Y-m-t', strtotime($startDate)); // Last day of the month
        $data = Meeting::whereBetween('start_date', [$startDate, $endDate])->get();
        return $data;
    }
    public function weekbaseddata(Request $request){
        $startDate = $request->startdate;
        $endDate = $request->enddate;
        $data = Meeting::whereBetween('start_date', [$startDate, $endDate])->get();
        return $data;
        print_r($request->all()) ;
    }
    public function daybaseddata(Request $request){
        $startDate = $request->date;
        $data = Meeting::where('start_date', $startDate)->get();
        return $data;
        print_r($request->all()) ;
    }
}
