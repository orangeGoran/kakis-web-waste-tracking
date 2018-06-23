<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WorkerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = DB::select('select * from users');
        return view('layouts.include.worker_page', ['users' => $users]);
    }

    public function delete(Request $request)
    {
        DB::table('users')->where('id', '=', $request->id)->delete();
    }

    public function changeType(Request $request)
    {
        DB::table('users')->where('id', '=', $request->id)->update(['type' => $request->newType]);
    }



}
