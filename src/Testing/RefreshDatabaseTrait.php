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

namespace Kilip\Laravel\Alice\Testing;

use Doctrine\ORM\Tools\SchemaTool;
use Doctrine\ORM\Tools\ToolsException;

trait RefreshDatabaseTrait
{
    public function refreshDatabase()
    {
        /** @var \Doctrine\Persistence\ManagerRegistry $registry */
        $registry = app()->get('registry');
        $managers = $registry->getManagers();
        $tool = new SchemaTool($registry->getManager());
        $metadatas = [];
        foreach ($managers as $manager) {
            $metadatas = array_merge($metadatas, $manager->getMetadataFactory()->getAllMetadata());
        }

        try {
            $tool->dropSchema($metadatas);
            $tool->createSchema($metadatas);
        } catch (ToolsException $e) {
            throw new \InvalidArgumentException(sprintf('Can not recreate database: %s', $e->getMessage()), $e->getCode(), $e);
        }
    }
}
