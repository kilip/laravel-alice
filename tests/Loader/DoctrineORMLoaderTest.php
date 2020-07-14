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
use Kilip\Laravel\Alice\Testing\ORM\RefreshDatabaseTrait;
use Tests\Kilip\Laravel\Alice\BaseTestCase;
use Tests\Kilip\Laravel\Alice\Fixtures\Group;
use Tests\Kilip\Laravel\Alice\Fixtures\User;

class DoctrineORMLoaderTest extends BaseTestCase
{
    use RefreshDatabaseTrait;

    protected function setUp(): void
    {
        parent::setUp();
        $this->app['config']->set('alice.doctrine_orm.default.paths', [__DIR__.'/../Resources/fixtures/test-load']);
    }

    public function testDefaultConfig()
    {
        $this->assertEquals('truncate', config('alice.doctrine_orm.default.purge_mode'));
    }

    public function testLoad()
    {
        $this->refreshDatabase();
        $ob = $this->getLoader();
        $ob->load();

        $users  = $this->getUserRepository()->findAll();
        $groups = $this->getGroupRepository()->findAll();

        $this->assertCount(10, $users);
        $this->assertCount(1, $groups);
    }

    public function testLoadWhenDevOnly()
    {
        $this->app['config']->set('app.env', 'production');
        $this->refreshDatabase();

        $users  = $this->getUserRepository()->findAll();
        $groups = $this->getGroupRepository()->findAll();

        $this->assertCount(0, $users);
        $this->assertCount(0, $groups);
    }

    /**
     * @return DoctrineORMLoader
     */
    private function getLoader()
    {
        return $this->app->get(DoctrineORMLoader::class);
    }

    /**
     * @return \Doctrine\Persistence\ObjectRepository
     */
    protected function getGroupRepository()
    {
        return $this
            ->getRegistry()
            ->getManagerForClass(Group::class)
            ->getRepository(Group::class);
    }

    /**
     * @return \Doctrine\Persistence\ObjectRepository
     */
    protected function getUserRepository()
    {
        return $this
            ->getRegistry()
            ->getManagerForClass(User::class)
            ->getRepository(User::class);
    }
}
