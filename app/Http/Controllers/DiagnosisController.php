<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Diagnos;
use App\Models\Consultation;
use Illuminate\Support\Facades\Auth;

class DiagnosisController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $diag = Diagnos::with('medicine_dispense')->orderBy('created_at', 'desc')->get();
        return response()->json($diag, 200);
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
            'diagnosis_name' => 'required|string',
            'symtoms' => 'required|string',
        ]);
        
        $con = Consultation::where('service_request_id', $request->service_request)->first();

        $diagnos = Diagnos::create([
            'service_request_id' => $request->service_request,
            'consultation' => $con->id,
            'diagnosis_name' => $request->diagnosis_name,
            'symtoms' => $request->symtoms,
        ]);

        return response()->json($diagnos, 200);
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
            'diagnosis_name' => 'required|string',
            'symtoms' => 'required|string',
        ]);
    
        $diagnos = Diagnos::find($id);
        $diagnos->diagnosis_name = $request->diagnosis_name;
        $diagnos->symtoms = $request->symtoms;
        $diagnos->save();

        return response()->json($diagnos, 200);
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
