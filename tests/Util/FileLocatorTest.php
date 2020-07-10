<?php

namespace Tests\Kilip\Laravel\Alice\Util;

use Kilip\Laravel\Alice\Util\FileLocator;
use PHPUnit\Framework\TestCase;

class FileLocatorTest extends TestCase
{
    /**
     * @var string
     */
    private $fixtureDir;

    protected function setUp(): void
    {
        $this->fixtureDir = realpath(__DIR__.'/../Resources/fixtures/file-locator');
    }

    public function testAddPaths()
    {
        $locator = new FileLocator();
        $locator->addPaths($dir = $this->fixtureDir);

        $files = $locator->find();
        $expectedFile = $this->fixtureDir.'/1.yml';

        $this->assertIsArray($files);
        $this->assertContains($expectedFile,$files);

        $locator->addPaths($dir);
        $this->assertCount(2, $files);
    }

    public function testAddPathsWithNonExistenceDir()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessageMatches('/"foo" not exists/');

        $fileLocator = new FileLocator();
        $fileLocator->addPaths('foo');
    }
}
