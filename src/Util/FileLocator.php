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

namespace Kilip\Laravel\Alice\Util;

use Symfony\Component\Finder\Finder as SymfonyFinder;

class FileLocator implements FileLocatorInterface
{
    /**
     * @var string[]
     */
    private $paths;

    public function __construct(array $paths = [])
    {
        $this->paths = $paths;
    }

    /**
     * {@inheritdoc}
     *
     * @return array
     */
    public function find(): array
    {
        $paths = $this->paths;
        $files = SymfonyFinder::create()
            ->files()
            ->in($paths)
            ->depth(0)
            ->name('/.*\.(ya?ml|php)$/i');

        $files = $files->sort(function ($a, $b) {
            return strcasecmp($a, $b);
        });

        $fixtureFiles = [];
        /** @var \Symfony\Component\Finder\SplFileInfo $file */
        foreach ($files as $file) {
            $fixtureFiles[$file->getRealPath()] = true;
        }

        return array_keys($fixtureFiles);
    }
}
