<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $columns = ['last_name','created_at'];
        $length = $request->length;
        $column = $request->column;
        $dir = $request->dir;
        $searchValue = $request->search;
        $query = User::where('role',0)->orderBy('last_name', 'asc');
    
        if($searchValue){
            $query->where(function($query) use ($searchValue){
                $query->where('last_name', 'like', '%'.$searchValue.'%')
                ->orWhere('middle_name', 'like', '%'.$searchValue.'%')
                ->orWhere('first_name', 'like', '%'.$searchValue.'%')
                ->orWhere('contact_number', 'like', '%'.$searchValue.'%');
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
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'middle_name' => 'required|string',
            'age' => 'required',
            'gender' => 'required',
            'birthdate' => 'required',
            'birth_place' => 'required',
            'civil_status' => 'required',
            'purok' => 'required',
            'occupation' => 'required|string',
            'contact_number' => 'required',
            'email' => 'required|string|email|unique:users,email',
            'username' => 'required|unique:users,username',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'last_name' => $request->last_name,
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'age' => $request->age,
            'gender' => $request->gender,
            'birthdate' => Carbon::parse($request->birthdate)->format('Y-m-d'),
            'birth_place' => $request->birth_place,
            'civil_status' => $request->civil_status,
            'contact_number' => $request->contact_number,
            'purok' => $request->purok,
            'occupation' => $request->occupation,
            'email' => $request->email,
            'username' => $request->username,
            'password' => bcrypt($request->password),
        ]);

        return response()->json($user, 200);
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
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'middle_name' => 'required|string',
            'age' => 'required',
            'gender' => 'required',
            'birthdate' => 'required',
            'birth_place' => 'required',
            'civil_status' => 'required',
            'occupation' => 'required|string',
            'contact_number' => 'required',
            'purok' => 'required',
            'email' => 'required|string|email',
            'username' => 'required|string',
            // 'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::find($id);
        $user->last_name = $request->last_name;
        $user->first_name = $request->first_name;
        $user->middle_name = $request->middle_name;
        $user->age = $request->age;
        $user->occupation = $request->occupation;
        $user->gender = $request->gender;
        $user->birthdate = Carbon::parse($request->birthdate)->format('Y-m-d');
        $user->birth_place = $request->birth_place;
        $user->civil_status = $request->civil_status;
        $user->contact_number = $request->contact_number;
        $user->purok = $request->purok;
        $user->email = $request->email;
        $user->username = $request->username;
        $user->save();

        return response()->json($user, 200);

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

    public function listPatient(){
        $user = User::orderBy('first_name', 'asc')->where('role', 0)->get();
        return response()->json($user, 200);
    }
}
