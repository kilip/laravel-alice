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

namespace Kilip\Laravel\Alice\Loader;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Fidry\AliceDataFixtures\Bridge\Doctrine\Persister\ObjectManagerPersister;
use Fidry\AliceDataFixtures\Bridge\Doctrine\Purger\Purger as DoctrinePurger;
use Fidry\AliceDataFixtures\Loader\PersisterLoader;
use Fidry\AliceDataFixtures\Loader\PurgerLoader;
use Fidry\AliceDataFixtures\Loader\SimpleLoader;
use Fidry\AliceDataFixtures\LoaderInterface;
use Fidry\AliceDataFixtures\Persistence\PersisterAwareInterface;
use Fidry\AliceDataFixtures\Persistence\PersisterInterface;
use Fidry\AliceDataFixtures\Persistence\PurgeMode;
use Kilip\Laravel\Alice\Util\FileLocator;
use Psr\Log\LoggerInterface;

class DoctrineORMLoader implements FixturesLoaderInterface
{
    /**
     * @var LoaderInterface|PersisterAwareInterface
     */
    private $loader;

    /**
     * @var array
     */
    private $configs = [];

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var \Doctrine\Persistence\ManagerRegistry
     */
    private $registry;

    public function __construct(SimpleLoader $simpleLoader, LoggerInterface $logger)
    {
        $manager         = app()->get('em');
        $omPersister     = new ObjectManagerPersister($manager);
        $purgerFactory   = new DoctrinePurger($manager, PurgeMode::createTruncateMode());
        $persisterLoader = new PersisterLoader($simpleLoader, $omPersister, $logger);

        $this->loader   = new PurgerLoader($persisterLoader, $purgerFactory, 'truncate', $logger);
        $this->configs  = config('alice.doctrine_orm');
        $this->logger   = $logger;
        $this->registry = app()->get('registry');
    }

    public function load(string $purgeMode=null)
    {
        $configs  = $this->configs;
        $registry = $this->registry;
        $objects  = [];
        $env      = config('app.env');

        foreach ($configs as $name => $config) {
            $devOnly = $config['dev_only'] ?? true;
            if ('production' === $env && $devOnly) {
                continue;
            }
            $managerName = $config['manager'] ?? $name;
            $purgeMode   = $config['purge_mode'] ?? 'truncate';
            $purgeMode   = $this->createPurgeMode($purgeMode);
            $om          = $registry->getManager($managerName);
            $persister   = $this->createPersister($om);
            $locator     = new FileLocator($config['paths']);
            $files       = $locator->find();
            $loader      = $this->loader->withPersister($persister);
            $objects     = array_merge(
                $objects,
                $loader->load($files, [], [], $purgeMode)
            );
        }

        return $objects;
    }

    /**
     * @param EntityManagerInterface|ObjectManager $entityManager
     *
     * @return PersisterInterface
     */
    private function createPersister(EntityManagerInterface $entityManager): PersisterInterface
    {
        return new ObjectManagerPersister($entityManager);
    }

    /**
     * @param string $mode
     *
     * @return PurgeMode
     */
    private function createPurgeMode($mode)
    {
        $map = [
            'no_purge' => 0,
            'delete'   => 1,
            'truncate' => 2,
        ];

        return new PurgeMode($map[$mode]);
    }
}
