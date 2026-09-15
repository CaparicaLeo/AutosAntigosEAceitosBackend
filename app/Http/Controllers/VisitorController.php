<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVisitorRequest;
use App\Http\Requests\UpdateVisitorRequest;
use App\Models\Visitor;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class VisitorController extends Controller
{
    public function index(): JsonResponse
    {
        $visitors = Visitor::all();

        return response()->json($visitors);
    }

    public function store(StoreVisitorRequest $request): JsonResponse
    {
        $visitor = Visitor::create($request->validated());

        return response()->json($visitor, Response::HTTP_CREATED);
    }

    public function show(Visitor $visitor): JsonResponse
    {
        return response()->json($visitor);
    }

    public function update(UpdateVisitorRequest $request, Visitor $visitor): JsonResponse
    {
        $visitor->update($request->validated());

        return response()->json($visitor);
    }

    public function destroy(Visitor $visitor): Response
    {
        $visitor->delete();

        return response()->noContent();
    }
}
