<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    private const BLOG_VALIDATION_RULES = [
        'title' => 'required|string|min:3|max:255',
        'tag' => 'nullable|string|max:100',
        'body' => 'required|string|min:10',
        'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        'published' => 'nullable|boolean',
    ];

    public function publicIndex()
    {
        $blogs = Blog::where('published', true)
            ->latest()
            ->paginate(9);

        return view('admin.blog.index', compact('blogs'));
    }

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
        $validated = $request->validate(self::BLOG_VALIDATION_RULES);
        $validated['slug'] = Str::slug($validated['title']) . '-' . time();
        $validated['image'] = $this->storeImage($request);
        $validated['published'] = $request->boolean('published', true);

        Blog::create($validated);

        return redirect()->route('admin.blog.index')
            ->with('success', '📝 Blog post "' . $validated['title'] . '" published!');    }

    public function show(string $slug)
    {
        $blog = Blog::where('slug', $slug)
            ->where('published', true)
            ->firstOrFail();

        return view('admin.blog.show', compact('blog'));
    }

    public function edit(Blog $blog)
    {
        return view('admin.blog.edit', compact('blog'));
    }

    public function update(Request $request, Blog $blog)
    {
        $validated = $request->validate(self::BLOG_VALIDATION_RULES);
        $validated['slug'] = Str::slug($validated['title']) . '-' . $blog->id;
        $validated['image'] = $this->storeImage($request, $blog->image);
        $validated['published'] = $request->boolean('published', true);

        $blog->update($validated);

        return redirect()->route('admin.blog.index')
            ->with('success', '✅ Blog post "' . $blog->fresh()->title . '" updated!');    }

    public function destroy(Blog $blog)
    {
        if ($blog->image) {
            Storage::disk('public')->delete($blog->image);
        }
        $title = $blog->title;
        $blog->delete();

        return redirect()->route('admin.blog.index')
            ->with('success', '🗑 Post "' . $title . '" deleted.');
    }

    public function togglePublish(Blog $blog)
    {
        $blog->update(['published' => ! $blog->published]);
        $status = $blog->published ? 'published' : 'unpublished';

        return back()->with('success', '"' . $blog->title . '" ' . $status . '.');
    }
     private function storeImage(Request $request, ?string $currentImage = null): ?string
    {
        if (! $request->hasFile('image') || ! $request->file('image')->isValid()) {
            return $currentImage;
        }

        if ($currentImage) {
            Storage::disk('public')->delete($currentImage);
        }

        return $request->file('image')->store('blog', 'public');
    }
}
