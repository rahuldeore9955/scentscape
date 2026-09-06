<?php

namespace App\Http\Controllers;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = collect($this->articles())
            ->flatMap(fn (array $article) => array_fill(0, 3, $article))
            ->values();

        return view('blogs.index', compact('blogs'));
    }

    public function show(string $slug)
    {
        $blog = collect($this->articles())->firstWhere('slug', $slug);
        abort_if(!$blog, 404);

        return view('blogs.show', compact('blog'));
    }

    private function articles(): array
    {
        return [
            ['slug' => 'choose-perfect-fragrance', 'category' => 'Guide', 'image' => 'photo-1523293182086-7651a899d37f', 'date' => 'June 10, 2026', 'time' => '5 min read', 'title' => 'How to Choose the Perfect Fragrance for Every Occasion', 'excerpt' => 'Discover the art of selecting the right perfume for different moments in your life.', 'intro' => 'Choosing the perfect fragrance can feel overwhelming with thousands of options available. This guide will help you discover scents that reflect your personality and suit each occasion.', 'sections' => [['title' => 'Understand fragrance families', 'text' => 'Floral fragrances feel romantic, woody scents are grounding, oriental notes are warm and expressive, and fresh fragrances are clean and uplifting. Start with the family that feels most natural to you.'], ['title' => 'Test fragrances properly', 'text' => 'Test a small number of fragrances on your skin, then give each one time to develop. A scent changes from its opening notes to its heart and base, so avoid deciding immediately.'], ['title' => 'Match the occasion', 'text' => 'Choose lighter and fresher scents for daytime or work, and richer woody, floral, or oriental fragrances for evenings and special occasions.']]],
        ];
    }
}
