<?php

namespace Album\Factory;

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

   /* public function createService(ServiceLocatorInterface $sm)
    {
        $entityManager = $sm->get('Doctrine\ORM\EntityManager');
        return new AlbumController($entityManager);
    }*/

    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $em = $container->get(EntityManager::class);
        return new AlbumController($container);
    }
}