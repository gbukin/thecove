<?php

namespace App\Http\Controllers;

use App\Models\News;
use Inertia\Inertia;
use App\Transformers\NewsTransformer;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\NewsRequest;
use Illuminate\Http\Request;
use App\Models\Language;
use App\Models\NewsData;

class NewsController extends Controller
{
    public function index()
    {
        return Inertia::render('News/Index');
    }

    public function data(Request $request)
    {
        $news = News::query();

        if ($rawSortColumn = $request->query('sortColumn')) {
            $sortDirection = $request->query('sortDirection');

            if ($rawSortColumn === 'ID') {
                $news = $news->orderBy('id', $sortDirection);
            } else {
                $sortColumnPart = explode(' ', strtolower($rawSortColumn));
                $sortColumn = $sortColumnPart[0];
                $sortColumnLanguage = $sortColumnPart[1];
                $news = $news->with([
                    'newsData' => fn ($query) => $query->orderBy($sortColumn, $sortDirection)
                        ->where('language', $sortColumnLanguage)
                ]);
            }

        }

        $search = $request->query('search');

        if ($search && $search !== '{}') {
            foreach ($request->query('search') as $column => $value) {
                if ($value !== null && $value !== 'undefined') {
                    $searchColumn = $column;

                    if (str_starts_with($column, 'title')) {
                        $searchColumn = 'title';
                    }

                    $lang = substr($column, strpos($column, '_') + 1, 2);

                    $news = $news->whereHas('newsData', function ($query) use ($searchColumn, $value, $lang) {
                        $query->where($searchColumn, 'ILIKE', '%' . mb_strtolower($value) . '%')
                            ->where('language', $lang);
                    });
                }
            }
        }

        return response()->json(
            (new NewsTransformer())->transform($news->get()),
        );
    }

    public function create()
    {
        return Inertia::render('News/Create')
            ->with(['languages' => Language::getLanguagesNames()]);
    }

    public function store(NewsRequest $request)
    {
        $news = News::create($request->validated());

        $languages = Language::getLanguagesNames();

        $news->validateData($request);

        foreach ($languages as $language) {
            $title = $request->get('title_' . $language) ?? '';
            $announce = $request->get('announce_' . $language) ?? '';
            $text = $request->get('text_' . $language) ?? '';

            NewsData::create([
                'title' => $title,
                'announce' => $announce,
                'text' => $text,
                'language' => $language,
                'news_id' => $news->id,
            ]);
        }

        return Redirect::route('news.index');
    }

    public function edit(News $news)
    {
        return Inertia::render('News/Edit')
            ->with(['news' => $news->load('newsData'), 'languages' => Language::getLanguagesNames()]);
    }

    public function update(NewsRequest $request, News $news)
    {
        $news->validateData($request);

        $languages = Language::getLanguagesNames();

        foreach ($languages as $language) {
            $newsDataId = $request->get('news_data_' . $language . '_id');
            $title = $request->get('title_' . $language) ?? '';
            $announce = $request->get('announce_' . $language) ?? '';
            $text = $request->get('text_' . $language) ?? '';

            NewsData::where(['id' => $newsDataId])->updateOrCreate(
                [
                    'news_id' => $news->id,
                    'language' => $language
                ],
                [
                    'news_id' => $news->id,
                    'title' => $title,
                    'announce' => $announce,
                    'text' => $text,
                ]
            );
        }

        $news->update($request->validated());

        return Redirect::back();
    }
}
