<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Language;
use App\Transformers\LanguageTransformer;
use Redirect;

class LanguageController extends Controller
{
    public function index()
    {
        return Inertia::render('Language/Index');
    }

    public function data()
    {
        $languages = Language::all();

        return response()->json(
            (new LanguageTransformer)->transform($languages),
        );
    }

    public function create()
    {
        return Inertia::render('Language/Create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:2|unique:languages']);

        Language::create(['name' => $request->get('name')]);

        return Redirect::route('language.index');
    }
}
