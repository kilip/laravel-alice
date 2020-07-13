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

namespace Kilip\Laravel\Alice;

use Fidry\AliceDataFixtures\Loader\SimpleLoader;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Kilip\Laravel\Alice\Loader\DoctrineORMLoader;
use Kilip\Laravel\Alice\Util\FileLocator;
use Nelmio\Alice\Loader\NativeLoader;
use Psr\Log\LoggerInterface;

class AliceServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public function boot()
    {
        $app = $this->app;

        $app->singleton(FileLocator::class, FileLocator::class);

        $app->singleton(SimpleLoader::class, function (Application $app) {
            $native = new NativeLoader();
            $logger = $app->get(LoggerInterface::class);

            return new SimpleLoader($native->getFilesLoader(), $logger);
        });

        $app->singleton(DoctrineORMLoader::class, function (Application $app) {
            return new DoctrineORMLoader($app->get(SimpleLoader::class));
        });

        $app->alias(DoctrineORMLoader::class, 'alice.loaders.doctrine_orm');
    }

    public function register()
    {
    }

    public function provides()
    {
        return [
            DoctrineORMLoader::class,
        ];
    }
}
