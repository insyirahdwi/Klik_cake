<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleCategory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function index(Request $request): View
    {
        $categories = ArticleCategory::where('is_active', true)
            ->withCount(['publishedArticles'])
            ->orderBy('sort_order')
            ->get();

        $query = Article::published()->with('category');

        if ($request->filled('kategori')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->query('kategori'));
            });
        }

        if ($request->filled('q')) {
            $keyword = '%' . $request->query('q') . '%';
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', $keyword)
                    ->orWhere('excerpt', 'like', $keyword)
                    ->orWhere('content', 'like', $keyword);
            });
        }

        $articles = $query->orderByDesc('published_at')->paginate(9)->withQueryString();

        $activeCategory = $request->filled('kategori')
            ? $categories->firstWhere('slug', $request->query('kategori'))
            : null;

        return view('shop.articles.index', compact('categories', 'articles', 'activeCategory'));
    }

    public function show(string $slug): View
    {
        $article = Article::published()
            ->with('category')
            ->where('slug', $slug)
            ->firstOrFail();

        // Increment view count
        $article->increment('view_count');

        // Related articles in same category
        $relatedArticles = Article::published()
            ->where('id', '!=', $article->id)
            ->where('category_id', $article->category_id)
            ->take(3)
            ->get();

        if ($relatedArticles->isEmpty()) {
            $relatedArticles = Article::published()
                ->where('id', '!=', $article->id)
                ->take(3)
                ->get();
        }

        return view('shop.articles.show', compact('article', 'relatedArticles'));
    }
}
