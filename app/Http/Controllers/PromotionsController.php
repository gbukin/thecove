<?php

namespace App\Http\Controllers;

use App\Models\Promotion;
use Inertia\Inertia;
use App\Transformers\PromotionsTransformer;
use Redirect;
use App\Http\Requests\PromotionRequest;
use App\Services\PromotionService;
use App\Models\Language;
use App\Models\NewsData;
use App\Models\PromotionData;

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
        return Inertia::render('Promotions/Create')
            ->with(['languages' => Language::getLanguagesNames()]);
    }

    public function store(PromotionRequest $request)
    {
        $promotion = Promotion::create($request->validated());

        if ($picture = $request->file('picture')) {
            PromotionService::saveFile($promotion, $picture);
        }

        $languages = Language::getLanguagesNames();

        $promotion->validateData($request);

        foreach ($languages as $language) {
            $title = $request->get('title_' . $language);
            $description = $request->get('description_' . $language);
            $body = $request->get('body_' . $language);

            PromotionData::create([
                'title' => $title,
                'description' => $description,
                'body' => $body,
                'language' => $language,
                'promotion_id' => $promotion->id,
            ]);
        }

        return Redirect::route('promotions.index');
    }

    public function edit(Promotion $promotion)
    {
        return Inertia::render('Promotions/Edit')->with([
            'promotion' => $promotion->load('promotionData'),
            'currentPicturePath' => $promotion->picture,
            'languages' => Language::getLanguagesNames(),
        ]);
    }

    public function update(PromotionRequest $request, Promotion $promotion)
    {
        $promotion->validateData($request);

        $languages = Language::getLanguagesNames();

        foreach ($languages as $language) {
            $newsDataId = $request->get('promotion_data_' . $language . '_id');
            $title = $request->get('title_' . $language);
            $description = $request->get('description_' . $language);
            $body = $request->get('body_' . $language);

            PromotionData::where(['id' => $newsDataId])->update([
                'title' => $title,
                'description' => $description,
                'body' => $body,
            ]);
        }

        $promotion->update($request->validated());

        if ($picture = $request->file('picture')) {
            PromotionService::saveFile($promotion, $picture);
        }

        return Redirect::back();
    }
}
