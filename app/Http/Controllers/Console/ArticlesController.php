<?php

namespace App\Http\Controllers\Console;

use App\Http\Requests\UpdateArticleRequest;
use App\Models\Article;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class ArticlesController
{
    public function index(Request $request)
    {
        abort_unless(in_array($request->state, [null, 'published', 'unpublished']), 404);

        $state = $request->get('state', 'published');

        return inertia('Console/Article/Index', [
            'articles' => Article::query()
                ->with('banner')
                ->when($state === 'unpublished', fn ($query) => $query->where('published_at', null))
                ->when($state === 'published', fn ($query) => $query->where('published_at', '<>', null))
                ->orderBy('updated_at', 'desc')
                ->get(),
            'unpublished_count' => Article::where('published_at', null)->count(),
            'published_count' => Article::where('published_at', '<>', null)->count(),
            'state' => $state,
        ]);

    }

    public function create()
    {
        return Inertia::modal('Console/Article/Create')->baseRoute('console.articles.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required', 'string', 'max:255', 'unique:articles,title'],
        ]);

        $article = Article::emptyWith($request->title);

        return to_route('console.articles.edit', $article);
    }

    public function show(Article $article) {}

    public function edit(Article $article)
    {
        $article->load('banner')->append('publishable');

        return inertia('Console/Article/Edit', [
            'article' => $article,
            'recipes' => Recipe::all(['id', 'title']),
        ]);
    }

    public function update(UpdateArticleRequest $request, Article $article)
    {
        $article->update($request->validated());

        return $article->append('publishable');
    }

    public function publish(Article $article)
    {
        if ($article->mustBeDraft()) {
            throw ValidationException::withMessages([
                'published_at' => 'La recette est incomplète et ne peut pas être publiée.',
            ]);
        }

        $article->published_at = now();
        $article->save();

        return to_route('console.articles.index', ['state' => 'published']);
    }
}
