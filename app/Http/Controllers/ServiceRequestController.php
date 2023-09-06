<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServiceRequest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ServiceRequestController extends Controller
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
        $query = ServiceRequest::with('schedule', 'medical_service', 'patient')
        ->where('service_request.status', 0)
        ->select('service_request.*', 
        'users.first_name', 
        'users.last_name', 
        'users.middle_name',
        'users.position',
        'users.gender',
        'users.contact_number',
        )->join('users', 'users.id', '=','service_request.user_id')
        ->orderBy('created_at', 'desc');
    
        if($searchValue){
            $query->where(function($query) use ($searchValue){
                $query->where('users.last_name', 'like', '%'.$searchValue.'%')
                ->orWhere('users.first_name', 'like', '%'.$searchValue.'%')
                ->orWhere('users.middle_name', 'like', '%'.$searchValue.'%');
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
       $pending = ServiceRequest::where('user_id', Auth::id())->where('status', 0)->get();

       if(count($pending)> 0){
            $errors = ['errors'=>['errs' => ["You have pending request!, you can't proceed!"]]];
            return response()->json($errors,400);
       }
       $request->validate([
           'schedule' => 'required',
           'medical_service' => 'required',
           'request_date' => 'required',
           'request_time' => 'required',
           ]);

        $date = Carbon::parse($request->request_date)->format('Y-m-d');
        $time = Carbon::createFromTime($request->request_time['hours'], $request->request_time['minutes'], $request->request_time['seconds']);

        $service = ServiceRequest::create([
            'schedule_id' => $request->schedule,
            'medical_service_id' => $request->medical_service,
            'user_id' => Auth::id(),
            'message' => $request->message,
            'request_date' => $date,
            'request_time' => $time
            ]);
        
        return response()->json($service, 200);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $service = ServiceRequest::with('patient', 'medical_service','consulted')->find($id);
        return response()->json($service, 200);
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
        //
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

    public function authRequest(Request $request){
    
        $length = $request->length;
        $searchValue = $request->search;
        $query = ServiceRequest::with('schedule', 'medical_service','consulted')
        ->where('status', 0)
        ->where('user_id', Auth::id())->orderBy('created_at', 'desc');
    
        if($searchValue){
            $query->where(function($query) use ($searchValue){
                // $query->where('medicine_name', 'like', '%'.$searchValue.'%');
            });
        }
        $projects = $query->paginate($length);
        return ['data'=>$projects, 'draw'=> $request->draw];
    }

    public function markAbsent(Request $request){
        $sereq = ServiceRequest::find($request->id);
        $sereq->status = 3;
        $sereq->save();
        return response()->json($sereq, 200);
    }

    public function addServiceRequest(Request $request){
      

        $request->validate([
            'schedule' => 'required',
            'medical_service' => 'required',
            'patient' => 'required',
            'request_date' => 'required',
            'request_time' => 'required'
            ]);
        $date = Carbon::parse($request->request_date)->format('Y-m-d');
        $time = Carbon::createFromTime($request->request_time['hours'], $request->request_time['minutes'], $request->request_time['seconds']);

         $service = ServiceRequest::create([
             'schedule_id' => $request->schedule,
             'medical_service_id' => $request->medical_service,
             'user_id' => $request->patient,
             'request_date' => $date,
             'request_time' => $time,
             ]);
         
         return response()->json($service, 200);
    }

    public function completeService($id){
        $sereq = ServiceRequest::find($id);
        $sereq->status = 1;
        $sereq->save();
        return response()->json($sereq, 200);
    }

    public function confirmCancel($id){
        $sereq = ServiceRequest::find($id);
        $sereq->status = 2;
        $sereq->save();
        return response()->json($sereq, 200);
    }


    public function completedSR(Request $request){

        $length = $request->length;
        $searchValue = $request->search;
        $query = ServiceRequest::with('schedule', 'medical_service', 'patient')
        ->where('service_request.status', 1)
        ->select('service_request.*', 
        'users.first_name', 
        'users.last_name', 
        'users.middle_name',
        'users.position',
        'users.gender',
        'users.contact_number',
        )->join('users', 'users.id', '=','service_request.user_id')
        ->orderBy('created_at', 'desc');
    
        if($searchValue){
            $query->where(function($query) use ($searchValue){
                $query->where('users.last_name', 'like', '%'.$searchValue.'%')
                ->orWhere('users.first_name', 'like', '%'.$searchValue.'%')
                ->orWhere('users.middle_name', 'like', '%'.$searchValue.'%');
            });
        }
        $projects = $query->paginate($length);
        return ['data'=>$projects, 'draw'=> $request->draw];
    }

    public function previousMed($id){
        $service = ServiceRequest::with('medical_service','consulted', 'schedule')
        ->where('user_id', $id)
        ->where('status', 1)
        ->orderBy('created_at', 'desc')
        ->get();
        return response()->json($service, 200);
    }

    public function doneMedication(Request $request){
        $length = $request->length;
        $searchValue = $request->search;
        $query = ServiceRequest::with('schedule', 'medical_service', 'consulted')
        ->where('user_id', Auth::id())
        ->where('status',"!=", 0)
        // ->where('status', 2)
        // ->where('status', 3)
        ->orderBy('created_at', 'desc');
    
        if($searchValue){
            $query->where(function($query) use ($searchValue){
                // $query->where('medicine_name', 'like', '%'.$searchValue.'%');
            });
        }
        $projects = $query->paginate($length);
        return ['data'=>$projects, 'draw'=> $request->draw];
    }
}
