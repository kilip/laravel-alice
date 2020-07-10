<?php


namespace Tests\Kilip\Laravel\Alice;


use Kilip\Laravel\Alice\AliceServiceProvider;
use LaravelDoctrine\ORM\DoctrineServiceProvider;
use Orchestra\Testbench\TestCase;

abstract class BaseTestCase extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            DoctrineServiceProvider::class,
            AliceServiceProvider::class
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        /* @var \Illuminate\Config\Repository $config */
        $config = $app['config'];

        $config->set('doctrine.managers.default.paths',[
            __DIR__.'/Fixtures'
        ]);


    }
}