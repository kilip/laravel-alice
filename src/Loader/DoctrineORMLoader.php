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

use Fidry\AliceDataFixtures\Bridge\Doctrine\Persister\ObjectManagerPersister;
use Fidry\AliceDataFixtures\Bridge\Doctrine\Purger\Purger;
use Fidry\AliceDataFixtures\Loader\PersisterLoader;
use Fidry\AliceDataFixtures\Loader\PurgerLoader;
use Fidry\AliceDataFixtures\Loader\SimpleLoader;
use Fidry\AliceDataFixtures\Persistence\PurgeMode;
use Kilip\Laravel\Alice\Util\FileLocator;
use Psr\Log\LoggerInterface;

class DoctrineORMLoader
{
    /**
     * @var PurgerLoader
     */
    private $loader;

    /**
     * @var FileLocator
     */
    private $locator;

    public function __construct(SimpleLoader $loader)
    {
        $this->configure($loader);
    }

    /**
     * @return FileLocator
     */
    public function getLocator(): FileLocator
    {
        return $this->locator;
    }

    public function load()
    {
        $files = $this->locator->find();
        $this->loader->load($files, [], [], PurgeMode::createTruncateMode());
    }

    private function configure(SimpleLoader $loader)
    {
        $paths     = config('alice.doctrine_orm.paths', []);
        $purgeMode = (string)config('alice.doctrine_orm.purge_mode', 'truncate');
        $om        = app()->get('em');
        $logger    = app()->get(LoggerInterface::class);

        $omPersister = new ObjectManagerPersister($om);
        $persister   = new PersisterLoader($loader, $omPersister, $logger);
        $purger      = new Purger($om);

        $this->loader  = new PurgerLoader($persister, $purger, $purgeMode, $logger);
        $this->locator = new FileLocator($paths);
    }
}
