<?php
namespace App\Http\Controllers\Tsks;

use App\Http\Controllers\Controller;
use App\Models\TaskComment;
use App\Models\TaskCommentFile;
use Illuminate\Http\Request;

class TaskCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */

     public function store(Request $request)
     {
         $request->validate([
             'task_id' => 'required|exists:tasks,id',
             'comment' => 'nullable|string',
             'files.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,docx,xlsx'
         ]);

         $comment = TaskComment::create([
             'task_id' => $request->task_id,
             'user_id' => auth()->id(),
             'comment' => $request->comment,
             'parent_id' => $request->parent_id,
         ]);

         if ($request->hasFile('files')) {
             foreach ($request->file('files') as $file) {
                 $path = $file->store('uploads/task-comments', 'public');
                 $fileType = $file->getClientOriginalExtension();

                 TaskCommentFile::create([
                     'task_comment_id' => $comment->id,
                     'task_id' => $request->task_id,
                     'file_path' => 'storage/' . $path,
                     'file_type' => $fileType,
                 ]);
             }
         }

         return back()->with('success', 'تم إضافة التعليق بنجاح');
     }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}