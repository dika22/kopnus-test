<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Application;

class ApplicationController extends Controller
{
    public function apply(Request $request) {
        if (auth()->user()->role !== 3) {
            return $this->response(['message' => 'Forbidden'], false, 403);
        }
        $request->validate([
            'job_id' => 'required|exists:jobs,id',
            'user_id' => 'required',
            'cv' => 'required|string',
            'status' => 'required|in:1,2,3', // 1 cv review, 2 user interview, 3 reject
        ]);

        $application = Application::create([
            'user_id' => auth()->id(),
            'job_id' => $request->job_id,
            'cv' => $request->cv,
            'status' => $request->status,
        ]);
    
        return response()->json($application, 201);
    }

    public function getApplicationByUserID(Request $request, $id) {
        $app = Application::where('user_id', $id)->get();
        return $this->response($app);
    }
}
