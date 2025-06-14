<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Translation;
use App\Models\Tag;

class TranslationController extends Controller
{
    //
   public function index(Request $request) {
        $query = Translation::with('tags');

        if ($request->has('tag')) {
            $query->whereHas('tags', fn($q) => $q->where('name', $request->tag));
        }
        if ($request->has('locale')) {
            $query->where('locale', $request->locale);
        }
        if ($request->has('key')) {
            $query->where('key', 'like', "%{$request->key}%");
        }
        if ($request->has('value')) {
            $query->where('value', 'like', "%{$request->value}%");
        }

        return response()->json($query->paginate(50));
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'locale' => 'required|string',
            'key' => 'required|string',
            'value' => 'required|string',
            'tags' => 'array',
        ]);

        $translation = Translation::create($validated);
        if ($request->tags) {
            $tagIds = Tag::whereIn('name', $request->tags)->pluck('id');
            $translation->tags()->sync($tagIds);
        }

        return response()->json($translation->load('tags'));
    }

    public function update(Request $request, Translation $translation) {
        $translation->update($request->only('value'));

        if ($request->tags) {
            $tagIds = Tag::whereIn('name', $request->tags)->pluck('id');
            $translation->tags()->sync($tagIds);
        }

        return response()->json($translation->load('tags'));
    }

    public function export(Request $request) {
        $translations = Translation::select('locale', 'key', 'value')->get();

        $result = [];
        foreach ($translations as $item) {
            $result[$item->locale][$item->key] = $item->value;
        }

        return response()->json($result);
    }
    

}
