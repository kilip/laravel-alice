<?php

namespace Tests\Kilip\Laravel\Alice\Loader;

use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Kilip\Laravel\Alice\Loader\DoctrineORMLoader;
use Kilip\Laravel\Alice\Testing\RefreshDatabaseTrait;
use Kilip\Laravel\Alice\Util\FileLocatorInterface;
use Nelmio\Alice\Loader\NativeLoader;
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

    protected function setUp(): void
    {
        parent::setUp();
        $this->registry = $this->getMockBuilder(ManagerRegistry::class)
            ->getMock();
        $this->locator = $this->getMockBuilder(FileLocatorInterface::class)
            ->getMock();
        $this->loader = new DoctrineORMLoader($this->registry, $this->locator);
    }

    public function testLoad()
    {
        $loader = $this->loader;
        $registry = $this->registry;
        $locator = $this->locator;
        $manager = $this->createMock(ObjectManager::class);

        $locator->expects($this->once())
            ->method('find')
            ->willReturn([
                __DIR__.'/../Resources/fixtures/test-load/test.yml'
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
        $this->app['config']->set('alice.paths',[
            __DIR__.'/../Resources/fixtures/test-load'
        ]);

        /* @var \Kilip\Laravel\Alice\Loader\DoctrineORMLoader $loader */
        $loader = app()->get('alice.doctrine');
        $loader->load();

        /* @var User[] $data */
        $repo = $this->getEntityManager()->getRepository(User::class);
        $data = $repo->findAll();
        $this->assertIsArray($data);
        $this->assertCount(10,$data);
        $this->assertInstanceOf(Group::class, $data[0]->getGroup());

        // group test
        $repo = $this->getEntityManager()->getRepository(Group::class);
        $data = $repo->findAll();
        $this->assertIsArray($data);
        $this->assertCount(1, $data);
    }

    /**
     * @param string $name
     * @return ObjectManager
     */
    protected function getEntityManager($name = null)
    {
        /* @var \Doctrine\Persistence\ManagerRegistry $registry */
        $registry = $this->app->get('registry');

        if(is_null($name)){
            $name = $registry->getDefaultManagerName();
        }
        return $registry->getManager($name);
    }
}
