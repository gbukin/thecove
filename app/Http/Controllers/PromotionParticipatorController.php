<?php

namespace App\Http\Controllers;

use App\Models\PromotionParticipator;
use Inertia\Inertia;
use App\Transformers\PromotionParticipatorsTransformer;

class PromotionParticipatorController extends Controller
{
    public function index()
    {
        return Inertia::render('PromotionParticipators/Index');
    }

    public function data()
    {
        return response()->json(
            (new PromotionParticipatorsTransformer())
                ->transform(PromotionParticipator::orderBy('id', 'DESC')->get())
        );
    }
}
