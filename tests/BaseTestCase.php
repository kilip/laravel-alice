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

use Doctrine\Persistence\ObjectManager;
use Kilip\Laravel\Alice\AliceServiceProvider;
use LaravelDoctrine\ORM\DoctrineServiceProvider;
use Orchestra\Testbench\TestCase;

abstract class BaseTestCase extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            DoctrineServiceProvider::class,
            AliceServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        /** @var \Illuminate\Config\Repository $config */
        $config = $app['config'];

        $config->set('doctrine.managers.default.paths', [
            __DIR__.'/Fixtures',
        ]);

        $config->set('alice.loader', 'alice.loader.doctrine');
    }

    /**
     * @param string $name
     *
     * @return ObjectManager
     */
    protected function getEntityManager($name = null)
    {
        /** @var \Doctrine\Persistence\ManagerRegistry $registry */
        $registry = $this->app->get('registry');

        if (null === $name) {
            $name = $registry->getDefaultManagerName();
        }

        return $registry->getManager($name);
    }
}
