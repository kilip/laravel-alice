<?php

namespace Tests\Kilip\Laravel\Alice;

use Kilip\Laravel\Alice\AliceServiceProvider;
use Kilip\Laravel\Alice\Loader\DoctrineORMLoader;
use Kilip\Laravel\Alice\Testing\RefreshDatabaseTrait;
use Tests\Kilip\Laravel\Alice\BaseTestCase;

class AliceServiceProviderTest extends BaseTestCase
{
    use RefreshDatabaseTrait;

    public function testDoctrineLoaderRegistered()
    {
        $ob = app()->get('alice.loader');

        $this->assertIsObject($ob);
        $this->assertInstanceOf(DoctrineORMLoader::class, $ob);
    }
}
