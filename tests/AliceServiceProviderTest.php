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

namespace Tests\Kilip\Laravel\Alice;

use Kilip\Laravel\Alice\Loader\DoctrineORMLoader;

class AliceServiceProviderTest extends BaseTestCase
{
    public function testLoadDoctrineORMLoader()
    {
        $loader = $this->app->get('alice.loaders.doctrine_orm');
        $this->assertInstanceOf(DoctrineORMLoader::class, $loader);
    }
}
