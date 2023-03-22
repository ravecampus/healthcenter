<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\schedule;
use Carbon\Carbon;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $length = $request->length;
        $searchValue = $request->search;
        $query = schedule::with('healthworker')->orderBy('created_at', 'asc');
    
        if($searchValue){
            $query->where(function($query) use ($searchValue){
                // $query->where('last_name', 'like', '%'.$searchValue.'%')
                // ->orWhere('middle_name', 'like', '%'.$searchValue.'%')
                // ->orWhere('first_name', 'like', '%'.$searchValue.'%')
                // ->orWhere('contact_number', 'like', '%'.$searchValue.'%');
            });
        }
        $projects = $query->paginate($length);
        return ['data'=>$projects, 'draw'=> $request->draw];
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
        $request->validate([
            "health_worker_id" => "required",
            "day"    => "required|array|min:1",
            "day.*"  => "required|min:1",
            "start_time" => "required",
            "end_time" => "required",
            "visible" => "required",
        ]);

        $start = Carbon::createFromTime($request->start_time['hours'], $request->start_time['minutes'], $request->start_time['seconds']);
        $end = Carbon::createFromTime($request->end_time['hours'], $request->end_time['minutes'], $request->end_time['seconds']);
        
        $sched = Schedule::create([
            'health_worker_id' => $request->health_worker_id,
            'day' => $request->days,
            'start_time' => $start,
            'end_time' => $end,
            'visible' => $request->visible,
        ]);
        
        return response()->json($sched, 200);
     
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        
        $request->validate([
            "health_worker_id" => "required",
            "day"    => "required|array|min:1",
            "day.*"  => "required|min:1",
            "start_time" => "required",
            "end_time" => "required",
            "visible" => "required",
        ]);

        if(is_string($request->start_time)){
            
            $start = Carbon::createFromTimeString($request->start_time);
        }else{
          
            $start = Carbon::createFromTime($request->start_time['hours'], $request->start_time['minutes'], $request->start_time['seconds']);
        }

        if(is_string($request->end_time)){
            $end = Carbon::createFromTimeString($request->end_time);
        }else{
            $end = Carbon::createFromTime($request->end_time['hours'], $request->end_time['minutes'], $request->end_time['seconds']);
        }
        
        $sched = Schedule::find($id);
            $sched->health_worker_id = $request->health_worker_id;
            $sched->day = $request->days;
            $sched->start_time = $start;
            $sched->end_time = $end;
            $sched->visible = $request->visible;
            $sched->save();
    
        return response()->json($sched, 200);
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

    public function scheduleVisble(Request $request){

        $req = $request->visible;
        if($req == 1){
            $ret = 2;
        }else{
            $ret = 1; 
        }

        $sched = Schedule::find($request->id);
        $sched->visible = $ret;
        $sched->save();
        return response()->json($sched, 200);
    }
}
