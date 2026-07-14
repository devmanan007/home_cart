<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Message;
use App\Models\Post;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home()
    {
        $recentPosts = Post::where('is_published', true)
            ->latest()
            ->take(3)
            ->get();

        $featuredProducts = Product::with(['category', 'primaryImage'])
            ->where('is_featured', true)
            ->where('is_active', true)
            ->take(6)
            ->get();

        $categories = Category::where('is_active', true)
            ->withCount('activeProducts')
            ->get();

        return view('home', compact('recentPosts', 'featuredProducts', 'categories'));
    }

    public function about()
    {
        return view('about');
    }

    public function careers()
    {
        $careers = Job::where('is_active', true)
            ->latest()
            ->get();

        return view('careers', compact('careers'));
    }

    public function blogs()
    {
        $posts = Post::where('is_published', true)
            ->latest()
            ->paginate(6);

        return view('blogs.index', compact('posts'));
    }

    public function blogDetail(string $slug)
    {
        $post = Post::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        return view('blogs.show', compact('post'));
    }

    public function contact()
    {
        return view('contact');
    }

    public function submitContactForm(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string'],
        ]);

        Message::create($validated);

        return redirect()->route('contact')
            ->with('success', 'Thank you! Your message has been received. We will get back to you shortly.');
    }
}
