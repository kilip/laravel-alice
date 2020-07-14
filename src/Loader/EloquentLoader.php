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

use Fidry\AliceDataFixtures\Bridge\Eloquent\Persister\ModelPersister;
use Fidry\AliceDataFixtures\Bridge\Eloquent\Purger\ModelPurger;
use Fidry\AliceDataFixtures\Loader\PersisterLoader;
use Fidry\AliceDataFixtures\Loader\PurgerLoader;
use Fidry\AliceDataFixtures\Loader\SimpleLoader;
use Illuminate\Database\DatabaseManager;
use Kilip\Laravel\Alice\Util\FileLocator;
use Psr\Log\LoggerInterface;

class EloquentLoader implements FixturesLoaderInterface
{
    /**
     * @var PurgerLoader
     */
    private $loader;

    /**
     * @var FileLocator
     */
    private $locator;

    public function __construct(
        SimpleLoader $simpleLoader,
        LoggerInterface $logger,
        DatabaseManager $databaseManager
    ) {
        $repository      = app()->get('migration.repository');
        $migrator        = app()->get('migrator');
        $path            = config('database.migrations');
        $purgeMode       = config('alice.eloquent.default.purge_mode');
        $modelPurger     = new ModelPurger($repository, $path, $migrator);
        $persister       = new ModelPersister($databaseManager);
        $persisterLoader = new PersisterLoader($simpleLoader, $persister, $logger);

        $this->loader  = new PurgerLoader($persisterLoader, $modelPurger, $purgeMode, $logger);
        $this->locator = new FileLocator();
    }

    /**
     * @return FileLocator
     */
    public function getLocator(): FileLocator
    {
        return $this->locator;
    }

    public function load(string $purgeMode = null)
    {
        $files  = $this->locator->find();
        $loader =$this->loader;

        $loader->load($files, [], []);
    }
}
