<?php

namespace App\Http\Controllers\Idea;

use Log;
use Carbon\Carbon;
use App\Models\Idea;
use App\Models\IdeaVote;
use App\Models\IdeaImage;
use App\Models\IdeaComment;
use App\Models\IdeaRoadmap;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;



class IdeaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index($id)
{
    $roadmaps = IdeaRoadmap::with('ideas')->findOrFail($id);
    return view('backend.idea.index', compact(var_name: 'roadmaps'));
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
    'title' => 'required|string|max:255',
    'description' => 'nullable|string',
    'idea_roadmap_id' => 'required|exists:idea_roadmaps,id',
    'files.*' => 'nullable|file|max:4096', // أي نوع ملف وليس image فقط
]);

    // إنشاء الفكرة
    $idea = Idea::create([
        'title' => $request->title,
        'description' => $request->description,
        'idea_roadmap_id' => $request->idea_roadmap_id,
        'created_by' => Auth::id(),
    ]);

    // رفع الصور أو الملفات
    if ($request->hasFile('files')) {
        $roadmap = IdeaRoadmap::find($request->idea_roadmap_id);
        $roadmapName = Str::slug($roadmap->name ?? 'roadmap');
        $ideaTitle = Str::slug($idea->title);
        $date = Carbon::now()->format('Y-m-d');

        foreach ($request->file('files') as $file) {
            $originalName = $file->getClientOriginalName();
            $fileName = time() . '_' . $originalName;
            $path = "idea_roadmaps/{$roadmapName}/{$ideaTitle}/{$date}";

            // إنشاء المجلد إن لم يكن موجود
            if (!\File::exists(public_path($path))) {
                \File::makeDirectory(public_path($path), 0755, true);
            }

            // نقل الملف
            $file->move(public_path($path), $fileName);

            // حفظ بيانات الصورة/الملف
            IdeaImage::create([
                'idea_id' => $idea->id,
                'image_path' => $path . '/' . $fileName,
            ]);
        }
    }

    return redirect()->back()->with('success', 'Idea created successfully with files.');
}


public function uploadImages(Request $request, Idea $idea)


{
    $request->validate([
        'images.*' => 'required|file|max:5120', // صورة أو ملف بحد أقصى 5 ميجا
    ]);

    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $file) {
            $date = now()->format('Y-m-d');
            $ideaRoadmapName = Str::slug(optional($idea->roadmap)->name ?? 'roadmap'); // تأكد من علاقة roadmap في model Idea
            $ideaTitle = Str::slug($idea->title);
            $originalName = $file->getClientOriginalName();
            $fileName = time() . '_' . $originalName;

            $path = "idea_roadmaps/{$ideaRoadmapName}/{$ideaTitle}/{$date}";
            $fullPath = public_path($path);

            // أنشئ المجلد إذا مش موجود
            if (!File::exists($fullPath)) {
                File::makeDirectory($fullPath, 0755, true);
            }

            // نقل الملف
            $file->move($fullPath, $fileName);

            // حفظ في قاعدة البيانات
            IdeaImage::create([
                'idea_id'    => $idea->id,
                'image_path' => "$path/$fileName",
            ]);
        }
    }

    return redirect()->back()->with('success', 'Files uploaded successfully.');
}

public function ajaxVote(Request $request, Idea $idea): JsonResponse
{
    $request->validate([
        'vote' => 'required|in:up,down',
    ]);

    $user = auth()->user();

    $existingVote = IdeaVote::where('idea_id', $idea->id)
        ->where('user_id', $user->id)
        ->first();

    if ($existingVote && $existingVote->vote === $request->vote) {
        $existingVote->delete();
    } elseif ($existingVote) {
        $existingVote->update(['vote' => $request->vote]);
    } else {
        IdeaVote::create([
            'idea_id' => $idea->id,
            'user_id' => $user->id,
            'vote' => $request->vote,
        ]);
    }

    $upvotes = $idea->votes()->where('vote', 'up')->count();
    $downvotes = $idea->votes()->where('vote', 'down')->count();

    return response()->json([
        'status' => 'success',
        'upvotes' => $upvotes,
        'downvotes' => $downvotes,
    ]);
}

public function comment(Request $request, Idea $idea)
{

    $request->validate([
        'comment' => 'required|string',
        'parent_id' => 'nullable|exists:idea_comments,id',
    ]);

    if (!auth()->check()) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    $comment = new IdeaComment();
    $comment->idea_id = $idea->id;
    $comment->user_id = auth()->id();
    $comment->comment = $request->comment;
    $comment->parent_id = $request->parent_id;
    $comment->save();

    Log::info('Comment saved', ['id' => $comment->id]);

    $html = view('backend.idea._comment', ['comment' => $comment])->render();

    return response()->json(['html' => $html]);
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
