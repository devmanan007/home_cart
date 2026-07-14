<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Job;
use App\Models\Message;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use App\Models\Category;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $postCount = Post::count();
        $jobCount = Job::count();
        $messageCount = Message::count();
        $publishedPostCount = Post::where('is_published', true)->count();
        $productCount = Product::count();
        $categoryCount = Category::count();
        $orderCount = Order::count();
        $pendingOrderCount = Order::where('status', 'pending')->count();
        $totalRevenue = Order::where('payment_status', 'paid')->sum('total');
        $customerCount = User::where('role', 'customer')->count();
        $recentOrders = Order::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'postCount',
            'jobCount',
            'messageCount',
            'publishedPostCount',
            'productCount',
            'categoryCount',
            'orderCount',
            'pendingOrderCount',
            'totalRevenue',
            'customerCount',
            'recentOrders'
        ));
    }
}
