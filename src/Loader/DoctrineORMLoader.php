<?php


namespace Kilip\Laravel\Alice\Loader;


use Doctrine\Persistence\ManagerRegistry;
use Kilip\Laravel\Alice\Util\FileLocatorInterface;
use Nelmio\Alice\Loader\NativeLoader;

class DoctrineORMLoader implements LoaderInterface
{
    /**
     * @var ManagerRegistry
     */
    private $registry;

    /**
     * @var FileLocatorInterface
     */
    private $locator;

    public function __construct(ManagerRegistry $registry, FileLocatorInterface $locator)
    {
        $this->registry = $registry;
        $this->locator = $locator;
    }

    public function load()
    {
        $locator = $this->locator;
        $loader = new NativeLoader();
        $files = $locator->find();

        /* @var \Nelmio\Alice\ObjectSet $objectSet */
        $objectSet = $loader->loadFiles($files);
        foreach($objectSet->getObjects() as $object){
            $this->persist($object);
        }
    }

    private function persist($object)
    {
        $registry = $this->registry;
        $em = $registry->getManagerForClass(get_class($object));

        $em->persist($object);
        $em->flush();
    }
}