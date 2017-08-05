<?php
namespace Album;

use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Zend\Router\Http\Segment;
//use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'controllers' => [
        'factories' => [
            \Album\Controller\AlbumController::class => \Album\Factory\AlbumControllerFactory::class,
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




    // SUPER DOC ABOUT DOCTRINE
    //https://olegkrivtsov.github.io/using-zend-framework-3-book/html/en/Database_Management_with_Doctrine_ORM/Creating_Entities.html


    /*
    /// Generate php model from table:
        ./vendor/doctrine/doctrine-module/bin/doctrine-module orm:convert-mapping \
         --namespace="Album\\Entity\\" --force  --from-database annotation ./module/Album/src/
    */
    'doctrine' => [
        'driver' => [
            'Album' => [
                'class' => AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [
                    __DIR__ . '/../src/Entity'
                ]
            ],
            'orm_default' => [
                'drivers' => [
                    'Album\\Entity' =>  'Album',
                ],
            ],
        ],
    ],


];