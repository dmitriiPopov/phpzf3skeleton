<?php

namespace Album\Controller\Factory;

use Album\Controller\AlbumController;
use Doctrine\ORM\EntityManager;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * Class AlbumControllerFactory
 * @package Album\Factory
 */
class AlbumControllerFactory
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $em = $container->get(EntityManager::class);
        return new AlbumController($container);
    }
}