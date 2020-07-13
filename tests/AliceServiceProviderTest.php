<?php

namespace Tests\Kilip\Laravel\Alice;

use Kilip\Laravel\Alice\AliceServiceProvider;
use Kilip\Laravel\Alice\Loader\DoctrineORMLoader;
use Tests\Kilip\Laravel\Alice\BaseTestCase;

class AliceServiceProviderTest extends BaseTestCase
{
    public function testLoadDoctrineORMLoader()
    {
        $loader = $this->app->get('alice.loaders.doctrine_orm');
        $this->assertInstanceOf(DoctrineORMLoader::class, $loader);
    }
}
