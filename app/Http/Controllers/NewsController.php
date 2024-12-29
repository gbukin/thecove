<?php

namespace App\Http\Controllers;

use App\Models\News;
use Inertia\Inertia;
use App\Transformers\NewsTransformer;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\NewsRequest;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        return Inertia::render('News/Index');
    }

    public function data(Request $request)
    {
        $columnMapper = fn(string $cell) => match ($cell) {
            'ID' => 'id',
            'Title' => 'title',
        };

        $news = News::orderBy(
            $columnMapper($request->query('sortColumn')),
            $request->query('sortDirection'),
        );

        $search = $request->query('search');

        if ($search && $search !== '{}') {
            foreach ($request->query('search') as $column => $value) {
                if ($value !== null && $value !== 'undefined') {
                    $news = $news->where($column, 'ILIKE', '%' . mb_strtolower($value) . '%');
                }
            }
        }

        return response()->json(
            (new NewsTransformer())->transform($news->get())
        );
    }

    public function create()
    {
        return Inertia::render('News/Create');
    }

    public function store(NewsRequest $request)
    {
        News::create($request->validated());

        return Redirect::route('news.index');
    }

    public function edit(News $news)
    {
        return Inertia::render('News/Edit')->with('news', $news);
    }

    public function update(NewsRequest $request, News $news)
    {
        $news->update($request->validated());

        return Redirect::back();
    }
}
