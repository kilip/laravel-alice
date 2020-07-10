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
use Kilip\Laravel\Alice\Util\FileLocatorInterface;
use Tests\Kilip\Laravel\Alice\BaseTestCase;
use Tests\Kilip\Laravel\Alice\Fixtures\Group;
use Tests\Kilip\Laravel\Alice\Fixtures\User;

class DoctrineORMLoaderTest extends BaseTestCase
{
    use RefreshDatabaseTrait;

    /**
     * @var DoctrineORMLoader
     */
    private $loader;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    private $registry;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    private $locator;

    /**
     * @var \PHPUnit\Framework\MockObject\MockObject
     */
    private $manager;

    protected function setUp(): void
    {
        parent::setUp();

        $registryClass = 'Doctrine\\Common\\Persistence\\ManagerRegistry';
        $omClass       = 'Doctrine\\Common\\Persistence\\ObjectManager';
        if (!interface_exists($omClass)) {
            $registryClass = 'Doctrine\\Common\\Persistence\\ManagerRegistry';
            $omClass       = 'Doctrine\\Common\\Persistence\\ObjectManager';
        }
        $this->manager  = $this->getMockBuilder($omClass)->getMock();
        $this->registry = $this->getMockBuilder($registryClass)->getMock();
        $this->locator  = $this->getMockBuilder(FileLocatorInterface::class)->getMock();
        $this->loader   = new DoctrineORMLoader($this->registry, $this->locator);
    }

    public function testLoad()
    {
        $manager  = $this->manager;
        $loader   = $this->loader;
        $registry = $this->registry;
        $locator  = $this->locator;

        $locator->expects($this->once())
            ->method('find')
            ->willReturn([
                __DIR__.'/../Resources/fixtures/test-load/test.yml',
            ]);
        $registry->expects($this->exactly(11))
            ->method('getManagerForClass')
            ->willReturn($manager);
        $registry->expects($this->atLeastOnce())
            ->method('getManagerForClass')
            ->willReturn($manager);

        $manager->expects($this->exactly(11))
            ->method('persist');
        $loader->load();
    }

    public function testSuccessfullyLoad()
    {
        $this->refreshDatabase();
        $this->app['config']->set('alice.paths', [
            __DIR__.'/../Resources/fixtures/test-load',
        ]);

        /** @var \Kilip\Laravel\Alice\Loader\DoctrineORMLoader $loader */
        $loader = app()->get('alice.loader');
        $loader->load();

        /** @var User[] $data */
        $repo = $this->getEntityManager()->getRepository(User::class);
        $data = $repo->findAll();
        $this->assertIsArray($data);
        $this->assertCount(10, $data);
        $this->assertInstanceOf(Group::class, $data[0]->getGroup());

        // group test
        $repo = $this->getEntityManager()->getRepository(Group::class);
        $data = $repo->findAll();
        $this->assertIsArray($data);
        $this->assertCount(1, $data);
    }
}
