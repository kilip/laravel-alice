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
    private $paths = [];

    public function __construct(array $paths = [])
    {
        $this->addPaths($paths);
    }

    /**
     * @param string|array $paths
     */
    public function addPaths($paths)
    {
        if (\is_string($paths)) {
            $paths = [$paths];
        }

        foreach ($paths as $path) {
            if (\in_array($path, $this->paths, true)) {
                continue;
            }
            if (!is_dir($path) || !is_writable($path)) {
                throw new \InvalidArgumentException(sprintf('The directory "%s" not exists.', $path));
            }
            $this->paths[] = $path;
        }
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
            $a = (string) $a;
            $b = (string) $b;

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
