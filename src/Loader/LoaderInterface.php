<?php


namespace Kilip\Laravel\Alice\Loader;


use Doctrine\Persistence\ObjectManager;
use Illuminate\Foundation\Application;

interface LoaderInterface
{
    public function load(
        Application $app,
        ObjectManager $om
    );
}