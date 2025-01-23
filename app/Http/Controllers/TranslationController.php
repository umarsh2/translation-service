<?php

namespace App\Http\Controllers;

use App\Http\Requests\TranslationRequest;
use App\Repositories\TranslationRepository;
use Illuminate\Http\Request;

class TranslationController extends Controller
{
    protected $translationRepository;

    public function __construct(TranslationRepository $translationRepository)
    {
        $this->translationRepository = $translationRepository;
    }

    public function index(Request $request)
    {
        return response()->json($this->translationRepository->search($request->all()));
    }

    public function store(TranslationRequest $request)
    {
        return response()->json($this->translationRepository->create($request->validated()));
    }

    public function update(TranslationRequest $request, $id)
    {
        return response()->json($this->translationRepository->update($id, $request->validated()));
    }

    public function destroy($id)
    {
        $this->translationRepository->delete($id);
        return response()->json(['message' => 'Deleted successfully']);
    }

    public function export()
    {
        return response()->json($this->translationRepository->export());
    }
}
