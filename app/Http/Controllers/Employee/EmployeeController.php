<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Employers;
use App\Models\Jobs;


class EmployeeController extends Controller
{
    public function index() {
        return Jobs::where('status', 1)->get();
    }
    
    public function store(Request $request) {
        if (auth()->user()->role !== 'employee') {
            return response()->json(['message' => 'Forbidden'], 403);
        }
    
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'status' => 'required|in:draft,published',
        ]);
    
        $job = Jobs::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
        ]);
    
        return response()->json($job, 201);
    }
}