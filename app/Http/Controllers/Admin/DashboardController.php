<?php
// File: app/Http/Controllers/Admin/DashboardController.php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\Tasks;


class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'users' => User::count(),
            'posts' => Post::count(),
            'tasks' => Tasks::count(),
        ];
        return view('admin.dashboard', compact('stats'));
    }
}

