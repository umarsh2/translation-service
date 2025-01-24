<?php

namespace App\Http\Controllers;

use App\Http\Requests\TranslationRequest;
use App\Repositories\TranslationRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TranslationController extends Controller
{
    private $repository;

    public function __construct(TranslationRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request): JsonResponse
    {
        $filters = $request->only(['key', 'content', 'locale', 'tags']);

        $results = $this->repository->search($filters);
        return response()->json($results);
    }

    public function store(TranslationRequest $request): JsonResponse
    {
        $translation = $this->repository->create($request->validated());
        return response()->json($translation, 201);
    }

    public function update(TranslationRequest $request, int $id): JsonResponse
    {
        $translation = $this->repository->update($id, $request->validated());
        return response()->json($translation);
    }

    public function show(int $id): JsonResponse
    {
        $translation = $this->repository->find($id);
        return response()->json($translation);
    }

    public function export(Request $request): JsonResponse
    {
        $locale = $request->locale ?? 'en';
        $translations = $this->repository->exportTranslations($locale);
        return response()->json($translations);
    }
}
