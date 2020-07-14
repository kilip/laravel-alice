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

use Doctrine\Common\Persistence\ManagerRegistry as CommonManagerRegistry;
use Doctrine\Common\Persistence\ObjectManager as CommonObjectManager;
use Doctrine\Persistence\ManagerRegistry as ManagerRegistry;
use Doctrine\Persistence\ObjectManager;

trait DoctrineTestTrait
{
    /**
     * @param string $name
     *
     * @return ObjectManager|CommonObjectManager
     */
    protected function getEntityManager($name = null)
    {
        /** @var ManagerRegistry|CommonManagerRegistry\ $registry */
        $registry = $this->app->get('registry');

        if (null === $name) {
            $name = $registry->getDefaultManagerName();
        }

        return $registry->getManager($name);
    }
}
