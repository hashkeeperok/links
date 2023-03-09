<?php

namespace Tests\Feature\Http\API;

use App\Http\Resources\API\LinkResource;
use App\Models\Link;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class LinksTest extends TestCase
{
    /**
     * @covers \App\Http\Controllers\Api\LinkController::index
     */
    public function testLinksIndex()
    {
        $links = Link::factory()->count(3)->create();

        /**
         * @var Link $link
         */
        foreach ($links as $link) {
            $link->attachTags(Arr::random(['tag1', 'tag2', 'tag3'], 2));
        }

        $firstLink = LinkResource::make($links->first())->jsonSerialize();
        $lastLink = LinkResource::make($links->last())->jsonSerialize();

        $this->getJson(route('api.links.index'))
             ->assertOk()
             ->assertJsonFragment($firstLink)
             ->assertJsonFragment($lastLink);

        $this->getJson(
            route('api.links.index') . '?' . http_build_query([
                'title' => $firstLink['title'],
            ]))
            ->assertOk()
            ->assertJsonFragment($firstLink)
            ->assertJsonMissing($lastLink);
    }

    /**
     * @covers \App\Http\Controllers\Api\LinkController::index
     */
    public function testLinksStore()
    {
        $link = Link::factory()->make()->toArray();
        unset($link['short_code']);

        $this->postJson(route('api.links.store'), $link)
             ->assertStatus(Response::HTTP_CREATED)
             ->assertJsonStructure([
                 'data' => [
                     'id',
                     'url',
                     'title',
                 ],
             ]);

        $this->assertDatabaseHas('links', $link);
    }
}
