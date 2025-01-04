<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use Inertia\Inertia;
use App\Transformers\PromotionsTransformer;
use Redirect;
use App\Http\Requests\PromotionRequest;
use App\Services\PromotionService;

class PromotionsController extends Controller
{
    public function index()
    {
        return Inertia::render('Promotions/Index');
    }

    public function data()
    {
        return response()->json(
            (new PromotionsTransformer())->transform(Promotion::orderBy('id', 'DESC')->get())
        );
    }

    public function create()
    {
        return Inertia::render('Promotions/Create');
    }

    public function store(PromotionRequest $request)
    {
        $promotion = Promotion::create($request->validated());

        if ($picture = $request->file('picture')) {
            PromotionService::saveFile($promotion, $picture);
        }

        return Redirect::route('promotions.index');
    }

    public function edit(Promotion $promotion)
    {
        return Inertia::render('Promotions/Edit')->with([
            'promotion' => $promotion,
            'currentPicturePath' => $promotion->picture,
        ]);
    }

    public function update(PromotionRequest $request, Promotion $promotion)
    {
        $promotion->update($request->validated());

        if ($picture = $request->file('picture')) {
            PromotionService::saveFile($promotion, $picture);
        }

        return Redirect::back();
    }
}
