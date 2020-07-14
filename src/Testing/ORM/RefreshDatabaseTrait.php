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

namespace Kilip\Laravel\Alice\Testing\ORM;

use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\ORM\Tools\ToolsException;
use Kilip\Laravel\Alice\Loader\DoctrineORMLoader;
use LaravelDoctrine\ORM\IlluminateRegistry;

trait RefreshDatabaseTrait
{
    protected $dbPopulated = false;

    /**
     * @return IlluminateRegistry
     */
    protected function getRegistry()
    {
        return app()->get('registry');
    }

    protected function refreshDatabase()
    {
        /** @var \Doctrine\ORM\EntityManagerInterface[] $managers */
        $registry  = $this->getRegistry();
        $managers  = $registry->getManagers();
        foreach ($managers as $manager) {
            try {
                $tool     = new SchemaTool($manager);
                $metadata = $manager->getMetadataFactory()->getAllMetadata();
                $tool->dropSchema($metadata);
                $tool->createSchema($metadata);
            } catch (ToolsException $e) {
                throw new \InvalidArgumentException(sprintf('Can not recreate database: %s', $e->getMessage()), $e->getCode(), $e);
            }
        }
        $this->populateDatabase();
    }

    protected function populateDatabase()
    {
        $loader = app()->get(DoctrineORMLoader::class);
        $loader->load();
        $this->dbPopulated = true;
    }
}
