<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\TrainerProfile;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $trainers = TrainerProfile::with(['user', 'category', 'reviews'])
            ->where('is_approved', true)
            ->orderBy('price_per_session', 'asc')
            ->take(3)
            ->get();

        $categories = Category::all();
        $trainerCount = TrainerProfile::where('is_approved', true)->count();
        $categoryCount = Category::count();

        return view('home', compact('trainers', 'categories', 'trainerCount', 'categoryCount'));
    }
}
