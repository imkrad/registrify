<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentAttachment;
use Illuminate\Http\Request;
use App\Http\Requests\ProfileRequest;

class ProfileController extends Controller
{
    public function index(Request $request){
        $options = $request->option;
        switch($options){
            default: 
            return inertia('Profile/Index');
        }
    }

    public function store(Request $request){
        $request->validate([
            'files.*' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048', // each file must be an image or PDF with max size of 2MB
        ]);
        $uploadedFiles = $request->file('files'); 
        $filePaths = [];

        foreach ($uploadedFiles as $file) {
            $path = $file->store('uploads', 'public');
            $filePaths[] = $path; 
            $fileSizeInBytes  = $file->getSize();
            if ($fileSizeInBytes >= 1048576) { // If 1 MB or more
                $fileSize = round($fileSizeInBytes / 1048576, 2) . ' MB';
            } else {
                $fileSize = round($fileSizeInBytes / 1024, 2) . ' KB';
            }

            StudentAttachment::create([
                'student_id' => \Auth::user()->student->id,
                'file' => $path,
                'size' => $fileSize
            ]);
        }

        Student::where('id',\Auth::user()->student->id)->update(['status_id' => 15]);

        return response()->json([
            'message' => 'Files uploaded successfully',
            'status' => 15,
            'file_paths' => $filePaths,
        ], 200);
    }

    public function update(ProfileRequest $request){
        $data = User::find(\Auth::user()->id);
        $data->profile()->update($request->except(['username', 'email']));
        
        return back()->with([
            'data' => $data,
            'message' => 'User update was successful!', 
            'info' => "You've successfully update user profile.",
            'status' => true
        ]);
    }
}
