<?php

/*
 * This file is part of the Kilip Laravel Alice project.
 *
 * (c) Anthonius Munthi <https://itstoni.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tests\Kilip\Laravel\Alice\Loader;

use Kilip\Laravel\Alice\Loader\EloquentLoader;
use Tests\Kilip\Laravel\Alice\BaseTestCase;
use Tests\Kilip\Laravel\Alice\Resources\Model\Eloquent\Group;
use Tests\Kilip\Laravel\Alice\Resources\Model\Eloquent\User;

class EloquentLoaderTest extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->loadMigrationsFrom(__DIR__.'/../Resources/eloquent-migrations');
    }

    public function testLoad()
    {
        $loader = $this->getFunctionalLoader();
        $loader->getLocator()->addPaths(__DIR__.'/../Resources/fixtures/eloquent');
        $loader->load();

        $users  = User::all();
        $groups = Group::all();
        $this->assertCount(10, $users);
        $this->assertCount(1, $groups);
    }

    /**
     * @return EloquentLoader
     */
    private function getFunctionalLoader()
    {
        return $this->app->get('alice.loaders.eloquent');
    }
}
