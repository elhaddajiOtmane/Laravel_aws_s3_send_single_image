<?php



namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'content' => 'required',
            'image' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        Log::info('Validated data:', $validatedData);
        $post = Post::create([
            'title' => $validatedData['title'],
            'content' => $validatedData['content'],
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 's3');
            $imageUrl = Storage::disk('s3')->url($imagePath);
            $post->image = $imageUrl;
            $post->save();
        }

        $imageUrl = $post->image ? $post->image : null;

        return response()->json([
            'success' => true,
            'message' => 'Post created successfully',
            'data' => [
                'id' => $post->id,
                'title' => $post->title,
                'content' => $post->content,
                'image' => $imageUrl,
            ],
        ], 200);
    }
}
