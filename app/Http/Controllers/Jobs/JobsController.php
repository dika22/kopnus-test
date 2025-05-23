<?php
namespace App\Http\Controllers\Jobs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Jobs;

class JobsController extends Controller
{
    public function index() {
        $result = Jobs::where('status', 2)->get(); // 1 draft 2 publish
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

    public function update(Request $request, $id)
    {
        $job = Jobs::find($id);
        if (!$job) {
            return response()->json(['message' => 'Job not found'], 404);
        }

        // Optional: ensure only the creator can update
        if ($job->user_id !== auth()->id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required',
        ]);

        $job->update($request->only('title', 'description', 'status'));

        return $this->response([
            'message' => 'Job updated successfully',
            'job' => $job,
        ], true, 200);
    }
    
    public function getJobByUserID(Request $request, $id){
        $jobs = Jobs::where('user_id', $id)->get();
        $jsonJobs = response()->json($jobs);
        return $this->response($jsonJobs->original);
    }
}
