<?php
namespace App\Http\Controllers\Jobs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Jobs;

class JobsController extends Controller
{
    public function index() {
        $result = Jobs::where('status', 1)->get();
        return $this->response($result);
    }
    
    public function store(Request $request) {
        if (auth()->user()->role === 3) {
            return $this->response(['message' => 'Forbidden'], false, 403);
        }
    
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'status' => 'required|in:0,1',
        ]);
    
        $job = Jobs::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
        ]);
        return $this->response($job, true, 201);
    }
    
    public function getJobByUserID(Request $request, $id){
        $jobs = Jobs::where('user_id', $id)->get();
        $jsonJobs = response()->json($jobs);
        return $this->response($jsonJobs->original);
    }
}
