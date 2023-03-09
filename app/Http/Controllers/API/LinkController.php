<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\LinkIndexRequest;
use App\Http\Requests\API\LinkStoreRequest;
use App\Http\Requests\API\LinkUpdateRequest;
use App\Http\Resources\API\LinkResource;
use App\Models\Link;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class LinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(LinkIndexRequest $request): AnonymousResourceCollection
    {
        $validated = $request->validated();
        $links = Link::query();

        if (isset($validated['tags'])) {
            $links = $links->withAnyTags($validated['tags']);
        }

        if (isset($validated['title'])) {
            $links = $links->where('title', $validated['title']);
        }

        return LinkResource::collection($links->paginate());
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(LinkStoreRequest $request): JsonResponse|AnonymousResourceCollection|LinkResource
    {
        $validated = $request->validated();

        if (isset($validated['links'])) {
            try {
                $links = [];

                foreach ($validated['links'] as $link) {
                    $links[] = $this->createLink($link);
                }
            } catch (Throwable $e) {
                return response()->json(['message' => $e->getMessage(), 500]);
            }

            return LinkResource::collection(collect($links));
        }

        try {
            $link = $this->createLink($validated);
        } catch (Throwable $e) {
            return response()->json(['message' => $e->getMessage(), 500]);
        }

        return LinkResource::make($link);
    }

    /**
     * Display the specified resource.
     */
    public function show(Link $link): LinkResource
    {
        return LinkResource::make($link->load('tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LinkUpdateRequest $request, Link $link): LinkResource|JsonResponse
    {
        try {
            $link->update($request->validated());
        } catch (Throwable $e) {
            return response()->json(['message' => $e->getMessage(), 500]);
        }

        return LinkResource::make($link);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Link $link): JsonResponse
    {
        try {
            $link->delete();
        } catch (Throwable $e) {
            return response()->json(['message' => $e->getMessage(), 500]);
        }

        return response()->json();
    }

    protected function createLink(array $linkData): Link
    {
        $link = Link::create([
            'long_url' => $linkData['long_url'],
            'short_code' => str_replace('-', '', Str::uuid()->toString()),
            'title' => $linkData['title'] ?? null,
        ]);

        if ($linkData['tags']) {
            $link->syncTags($linkData['tags']);
        }

        return $link;
    }
}
