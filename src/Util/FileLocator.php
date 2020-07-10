<?php


namespace Kilip\Laravel\Alice\Util;


use Symfony\Component\Finder\Finder as SymfonyFinder;

class FileLocator implements FileLocatorInterface
{
    /**
     * @var string[]
     */
    private $paths;

    public function __construct(array $paths=[])
    {
        $this->paths = $paths;
    }

    /**
     * @inheritDoc
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
        /* @var \Symfony\Component\Finder\SplFileInfo $file */
        foreach ($files as $file) {
            $fixtureFiles[$file->getRealPath()] = true;
        }

        return array_keys($fixtureFiles);
    }
}