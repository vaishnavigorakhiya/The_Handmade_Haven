<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::latest()->paginate(15);
        return view('admin.blog.index', compact('blogs'));
    }

    public function create()
    {
        return view('admin.blog.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'     => 'required|string|min:3|max:255',
            'tag'       => 'nullable|string|max:100',
            'body'      => 'required|string|min:10',
            'image'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'published' => 'nullable|boolean',
        ]);

        $imagePath = null;
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $imagePath = $request->file('image')->store('blog', 'public');
        }

        Blog::create([
            'title'     => $request->title,
            'slug'      => Str::slug($request->title) . '-' . time(),
            'tag'       => $request->tag,
            'body'      => $request->body,
            'image'     => $imagePath,
            'published' => $request->boolean('published', true),
        ]);

        return redirect()->route('admin.blog.index')
            ->with('success', '📝 Blog post "' . $request->title . '" published!');
    }

        public function show(string $slug)
    {
        $blog = Blog::where('slug', $slug)
                    ->where('published', true)
                    ->firstOrFail();
        return view('blog.show', compact('blog'));
    }

    public function edit(Blog $blog)
    {
        return view('admin.blog.edit', compact('blog'));
    }

    public function update(Request $request, Blog $blog)
    {
        $request->validate([
            'title'     => 'required|string|min:3|max:255',
            'tag'       => 'nullable|string|max:100',
            'body'      => 'required|string|min:10',
            'image'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'published' => 'nullable|boolean',
        ]);

        $imagePath = $blog->image;
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            if ($blog->image) Storage::disk('public')->delete($blog->image);
            $imagePath = $request->file('image')->store('blog', 'public');
        }

        $blog->update([
            'title'     => $request->title,
            'slug'      => Str::slug($request->title) . '-' . $blog->id,
            'tag'       => $request->tag,
            'body'      => $request->body,
            'image'     => $imagePath,
            'published' => $request->boolean('published', true),
        ]);

        return redirect()->route('admin.blog.index')
            ->with('success', '✅ Blog post "' . $blog->title . '" updated!');
    }

    public function destroy(Blog $blog)
    {
        if ($blog->image) Storage::disk('public')->delete($blog->image);
        $title = $blog->title;
        $blog->delete();
        return redirect()->route('admin.blog.index')
            ->with('success', '🗑 Post "' . $title . '" deleted.');
    }

    public function togglePublish(Blog $blog)
    {
        $blog->update(['published' => !$blog->published]);
        $status = $blog->published ? 'published' : 'unpublished';
        return back()->with('success', '"' . $blog->title . '" ' . $status . '.');
    }
}
