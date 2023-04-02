<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MedicineDispense;
use Illuminate\Support\Facades\Auth;

class MedicineDispenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $med = MedicineDispense::orderBy('created_at', 'desc')->get();
        return response()->json($med, 200);
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
            'medicine_id' => 'required',
            'quantity' => 'required',
            'every_take' => 'required',
            'times' => 'required',
        ]);
        $med = MedicineDispense::create([
            'diagnos_id' => $request->diagnos_id,
            'medicine_id' => $request->medicine_id,
            'quantity' => $request->quantity,
            'every_take' => $request->every_take,
            'times' => $request->times,
            'note' => $request->note,
        ]);

        return response()->json($med, 200);
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
            'medicine_id' => 'required',
            'quantity' => 'required',
            'every_take' => 'required',
            'times' => 'required',
        ]);
        $med = MedicineDispense::find($id);
        $med->medicine_id = $request->medicine_id;
        $med->quantity = $request->quantity;
        $med->every_take = $request->every_take;
        $med->times = $request->times;
        $med->note = $request->note;
        $med->save();

        return response()->json($med, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $med = MedicineDispense::find($id);
        $med->delete();
        return response()->json($med, 200);
    }
}
