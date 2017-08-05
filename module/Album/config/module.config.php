<?php
namespace Album;

use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'controllers' => [
        'factories' => [
            Controller\AlbumController::class => InvokableFactory::class,
        ],
    ],

    // The following section is new and should be added to your file:
    'router' => [
        'routes' => [
            'album' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/album[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\AlbumController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],

    'view_manager' => [
        'template_path_stack' => [
            'album' => __DIR__ . '/../view',
        ],
    ],

## Generate php model from table:
## ./vendor/doctrine/doctrine-module/bin/doctrine-module orm:convert-mapping --namespace="Album\\Entity\\" --force  --from-database annotation ./module/Album/src/
    'doctrine' => array(
        'driver' => array(
            'Album_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/Model')
            ),
            'orm_default' => array(
                'drivers' => array(
                    'Album\Model' =>  'Album_driver'
                ),
            ),
        ),
    ),


];