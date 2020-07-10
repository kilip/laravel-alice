<?php


namespace Kilip\Laravel\Alice\Loader;

interface LoaderInterface
{
    /**
     * Load fixtures
     *
     * @return void
     */
    public function load();
}