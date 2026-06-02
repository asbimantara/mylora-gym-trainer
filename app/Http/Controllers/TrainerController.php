<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\TrainerProfile;
use Illuminate\Http\Request;

class TrainerController extends Controller
{
    public function index(Request $request)
    {
        $query = TrainerProfile::with(['user', 'category', 'reviews', 'packages' => fn($q) => $q->where('is_active', true)])
            ->where('is_approved', true);

        if ($request->filled('category')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }
        if ($request->filled('location')) {
            $query->where('location', 'like', '%' . $request->location . '%');
        }
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', fn($q2) => $q2->where('name', 'like', "%{$search}%"))
                  ->orWhere('specialization', 'like', "%{$search}%")
                  ->orWhere('gym_name', 'like', "%{$search}%");
            });
        }

        $sort = $request->get('sort', 'price_low');
        match($sort) {
            'price_low' => $query->orderBy('price_per_session', 'asc'),
            'price_high' => $query->orderBy('price_per_session', 'desc'),
            'experience' => $query->orderBy('experience_years', 'desc'),
            default => $query->orderBy('price_per_session', 'asc'),
        };

        $trainers = $query->paginate(9);
        $categories = Category::all();

        return view('trainers.index', compact('trainers', 'categories'));
    }

    public function show($id)
    {
        $profile = TrainerProfile::with([
            'user', 'category',
            'availabilities' => fn($q) => $q->where('is_available', true)->orderBy('day_of_week'),
            'packages' => fn($q) => $q->where('is_active', true)->orderBy('session_count'),
            'reviews.user',
        ])->where('is_approved', true)->findOrFail($id);

        return view('trainers.show', compact('profile'));
    }
}
