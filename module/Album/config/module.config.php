<?php
namespace Album;

use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

//use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'controllers' => [
        'factories' => [
            \Album\Controller\AlbumController::class => \Album\Controller\Factory\AlbumControllerFactory::class,
        ],
    ],

    'controller_plugins' => [
        'factories' => [
            Controller\Plugin\HelloWorldPlugin::class => InvokableFactory::class,
        ],
        'aliases' => [
            'helloworld' => Controller\Plugin\HelloWorldPlugin::class,
        ],
    ],

    'view_helpers' => [
        'factories' => [
            View\Helper\SimpleListViewHelper::class => InvokableFactory::class,
        ],
        'aliases' => [
            'simpleList' => View\Helper\SimpleListViewHelper::class
        ]
    ],

    // The following section is new and should be added to your file:
    'router' => [
        'routes' => [

            //'router_class' => TreeRouteStack::class, // <- default handler

            //route `album`
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

            //route `albumhome`
            'albumhome' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/album',
                    'defaults' => [
                        'controller' => Controller\AlbumController::class,
                        'action'     => 'index',
                    ],
                ],
            ],

            //custom route (/help)
            'static' => [
                'type' => Route\StaticRoute::class,
                'options' => [
                    'dir_name'         => __DIR__ . '/../view',
                    'template_prefix'  => 'album/album/static',
                    'filename_pattern' => '/[a-z0-9_\-]+/',
                    'defaults' => [
                        'controller' => Controller\AlbumController::class,
                        'action'     => 'static',
                    ],
                ],
            ],
        ],
    ],

    'view_manager' => [
        'template_path_stack' => [
            'album' => __DIR__ . '/../view',
        ],
        'strategies' => [
            'ViewJsonStrategy',
        ],
    ],

    'navigation' => [
        'default' => [
            [
                'label' => 'Home',
                'route' => 'home',
            ],
            [
                'label' => 'Album',
                'route' => 'album',
                'pages' => [
                    [
                        'label'  => 'Add',
                        'route'  => 'album',
                        'action' => 'add',
                    ],
                    [
                        'label'  => 'Edit',
                        'route'  => 'album',
                        'action' => 'edit',
                    ],
                    [
                        'label'  => 'Delete',
                        'route'  => 'album',
                        'action' => 'delete',
                    ],
                ],
            ],
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