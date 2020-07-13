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

use Kilip\Laravel\Alice\Loader\DoctrineORMLoader;
use Kilip\Laravel\Alice\Testing\RefreshDatabaseTrait;
use Tests\Kilip\Laravel\Alice\BaseTestCase;
use Tests\Kilip\Laravel\Alice\Fixtures\User;

class DoctrineORMLoaderTest extends BaseTestCase
{
    use RefreshDatabaseTrait;

    protected function setUp(): void
    {
        parent::setUp();

        $this->refreshDatabase();
    }

    public function testLoad()
    {
        $ob = $this->getLoader();
        $ob->getLocator()->addPaths(__DIR__.'/../Resources/fixtures/test-load');
        $ob->load();

        $em   = $this->getRegistry()->getManagerForClass(User::class);
        $repo = $em->getRepository(User::class);
        $data = $repo->findAll();

        $this->assertCount(10, $data);
    }

    /**
     * @return DoctrineORMLoader
     */
    private function getLoader()
    {
        return $this->app->get(DoctrineORMLoader::class);
    }
}
