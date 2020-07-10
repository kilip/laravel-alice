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
use Kilip\Laravel\Alice\Testing\RefreshDatabaseTrait;

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
