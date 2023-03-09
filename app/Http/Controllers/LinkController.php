<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\LinkIndexRequest;
use App\Http\Requests\API\LinkStoreRequest;
use App\Http\Requests\API\LinkUpdateRequest;
use App\Http\Resources\API\LinkResource;
use App\Models\Link;
use App\Models\Transition;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class LinkController extends Controller
{
    public function transit(string $code): JsonResponse|RedirectResponse
    {
        $link = Link::where('short_code', $code)->first();

        if (!$link) {
            return response()->json([
                'message' => 'Link not found',
            ], Response::HTTP_NOT_FOUND);
        }

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        Transition::create([
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? null,
            'ip' => $ip,
            'link_id' => $link->id,
        ]);

        return redirect()->to($link->long_url);
    }
}
