<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class JobController extends Controller
{
    // Method untuk menampilkan semua pekerjaan
    public function index()
    {
        $jobs = Job::with('picDesigner')->get();
        return response()->json(['jobs' => $jobs], 200);
    }

    // Method untuk menyimpan pekerjaan baru
    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'status' => ['required', Rule::in(['proses', 'return', 'hold', 'approve'])],
            'deadline' => 'nullable|date',
            'title' => 'required|string',
            'client' => 'required|string',
            'description' => 'required|string',
            'pic_designer_id' => [
                'required',
                'exists:users,id',
                Rule::exists('users', 'id')->where(function ($query) {
                    $query->where('role', 'Designer');
                }),
            ],
            'file' => 'required|file|mimes:pdf|max:2048',
            'file_designer' => 'nullable|file|mimes:pdf|max:2048',
            'komen_koordinator' => 'nullable|string',
            'komen_qc' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads'), $fileName);
        $job = new Job();

        $job->status = $request->status; 
        $job->deadline = $request->deadline;
        $job->hari = $request->daysRemaining;
        $job->title = $request->title;
        $job->client = $request->client;
        $job->description = $request->description;
        $job->pic_designer_id = $request->pic_designer_id;
        $job->file_path = 'uploads/'.$fileName;
        $job->save();

        return response()->json(['message' => 'Job created successfully'], 201);
    }

    // Method untuk menampilkan detail pekerjaan
    public function show($id)
    {
        $job = Job::find($id);
        if (!$job) {
            return response()->json(['message' => 'Job not found'], 404);
        }
        return response()->json(['job' => $job], 200);
    }

    // Method untuk mengupdate pekerjaan
    public function update(Request $request, $id)
    {
        
        $validator = Validator::make($request->all(), [
            'status' => ['required', Rule::in(['proses', 'return', 'hold', 'approve'])],
            'deadline' => 'required|date',
            'hari' => 'integer',
            'title' => 'required|string',
            'client' => 'required|string',
            'description' => 'required|string',
            'pic_designer_id' => [
                'required',
                'exists:users,id',
                Rule::exists('users', 'id')->where(function ($query) {
                    $query->where('role', 'Designer');
                }),
            ],
            'file' => 'file|mimes:pdf|max:2048',
            'file_designer' => 'file|mimes:pdf|max:2048',
            'komen_koordinator' => 'required|string',
            'komen_qc' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $job = Job::find($id);
        if (!$job) {
            return response()->json(['message' => 'Job not found'], 404);
        }

        $job->status = $request->status; 
        $job->deadline = $request->deadline;
        $job->title = $request->title;
        $job->client = $request->client;
        $job->description = $request->description;
        $job->pic_designer_id = $request->pic_designer_id;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $fileName);
            $job->file_path = $fileName;
        }

        $job->save();

        return response()->json(['message' => 'Job updated successfully'], 200);
    }

    
    public function destroy($id)
    {
        $job = Job::find($id);
        if (!$job) {
            return response()->json(['message' => 'Job not found'], 404);
        }

        
        if ($job->file_path) {
            $filePath = public_path('uploads') . '/' . $job->file_path;
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        $job->delete();
        return response()->json(['message' => 'Job deleted successfully'], 200);
    }
}
