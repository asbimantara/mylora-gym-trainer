<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TrainerProfile;
use App\Models\Category;

class OnboardingController extends Controller
{
    public function index()
    {
        return view('member.onboarding');
    }

    public function process(Request $request)
    {
        $request->validate([
            'goal' => 'required|string',
            'level' => 'required|string',
        ]);

        $goal = $request->goal;
        $categorySlug = 'weight-training'; // default
        
        if ($goal === 'fat_loss') {
            $categorySlug = 'cardio-hiit';
        } elseif ($goal === 'muscle_gain') {
            $categorySlug = 'weight-training';
        } elseif ($goal === 'flexibility') {
            $categorySlug = 'yoga-flexibility';
        } elseif ($goal === 'stamina') {
            $categorySlug = 'functional-training';
        }

        // Cari kategori berdasarkan slug
        $category = Category::where('slug', $categorySlug)->first();
        
        // Cari trainer yang punya kategori ini
        $trainer = null;
        if ($category) {
            $trainer = TrainerProfile::where('category_id', $category->id)->where('is_approved', true)->with(['user', 'packages'])->first();
        }

        // Fallback jika tidak ada trainer di kategori tersebut
        if (!$trainer) {
            $trainer = TrainerProfile::where('is_approved', true)->with(['user', 'packages'])->first();
        }

        return view('member.recommendation', [
            'trainer' => $trainer,
            'goal' => $goal
        ]);
    }
}
