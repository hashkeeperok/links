<?php
namespace Tests;
use Illuminate\Support\Facades\Artisan;
trait MigrateFreshOnce
{
    /**
     * If true, setup has run at least once.
     *
     * @var bool
     */
    protected static bool $setUpHasRunOnce = false;
    /**
     * After the first run of setUp "migrate:fresh"
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        if (!static::$setUpHasRunOnce) {
            Artisan::call('migrate:fresh');
            static::$setUpHasRunOnce = true;
        }
    }
}
