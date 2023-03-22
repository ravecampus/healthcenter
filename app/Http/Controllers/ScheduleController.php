<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\schedule;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        
        $sched = Schedule::create([
            'health_worker_id' => $request->health_worker_id,
            'day' => $request->days,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
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
        
        $sched = Schedule::find($id);
            $sched->health_worker_id = $request->health_worker_id;
            $sched->day = $request->days;
            $sched->start_time = $request->start_time;
            $sched->end_time = $request->end_time;
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
}
