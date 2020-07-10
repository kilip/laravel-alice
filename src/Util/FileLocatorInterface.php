<?php


namespace Kilip\Laravel\Alice\Util;


interface FileLocatorInterface
{
    /**
     * @return string[] files
     */
    public function find(): array;
}