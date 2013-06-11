<?php
/*
 * Module config for CMS
 */

namespace Admin;

return array(

    'controllers' => array(
        'invokables' => array(
            'Admin\Controller\Index' => 'Admin\Controller\IndexController',
            'Admin\Controller\Album' => 'Admin\Controller\AlbumController',
            'Admin\Controller\Test' => 'Admin\Controller\TestController',
        ),
    ),

    'router' => array(
        'routes' => array(

            'admin' => array(
                
                'type' => 'Literal',
                'options' => array(
                    'route' => '/admin',
                    'defaults' => array(
                        '__NAMESPACE__' => 'Admin\Controller',
                        'controller'    => 'Index',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,                
                
                'child_routes' => array(
                    
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:action][/][/:id][/]',
                            /*'constraints' => array(
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),*/
                        ),
                    ),
                    
                    'login' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/login',
                            'defaults' => array(
                                'action' => 'login'
                            )
                        )
                    ),
                    'logout' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/logout',
                            'defaults' => array(
                                'action' => 'logout'
                            )
                        )
                    ),
                    'album' => array(
                        'type'    => 'segment',
                        'options' => array(
                            'route'    => '/album[/:action][/:id][/]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id'     => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller' => 'Album',
                                'action'     => 'index',
                            ),
                        ),
                    ), 
                    'test' => array(
                        'type'    => 'segment',
                        'options' => array(
                            'route'    => '/test[/:action][/:id][/]',
                            'constraints' => array(
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'id'     => '[0-9]+',
                            ),
                            'defaults' => array( 
                                'controller' => 'Test',
                                'action'     => 'index',
                            ),
                        ),
                    ),                    
                ),

                
            ),
            
            
        ),
    ),   
    
    
    'navigation' => array(
        'admin' => array(
            'Home' => array(
                'label' => 'Home',
                'route' => 'admin',
                'pages' => array(
                    array(
                        'label' => 'Login',
                        'route' => 'login',
                        'action' => 'login',
                    ),
                    array(
                        'label' => 'Logout',
                        'route' => 'logout',
                        'action' => 'logout',
                    ),
                )
            ),
            'Albums' => array(
                'label' => 'Albums',
                'route' => 'admin/album',
                'pages' => array(
                    array(
                        'label' => 'Add',
                        'route' => 'album',
                        'action' => 'add',
                    ),
                    array(
                        'label' => 'Edit',
                        'route' => 'album',
                        'action' => 'edit',
                    ),
                    array(
                        'label' => 'Delete',
                        'route' => 'album',
                        'action' => 'delete',
                    ),
                )
            ),
            'Test' => array(
                'label' => 'Test',
                'route' => 'admin/test'
            )
        ),
    ),
    
    
    'service_manager' => array(
        
        'factories' => array(
            'admin_navigation' => 'Admin\Navigation\Service\AdminNavigationFactory',            
        ),
        'services' => array(
        )
    ),
    

    'view_manager' => array(
        //'not_found_template'       => 'admin/404',
        //'exception_template'       => 'admin/index',
        'template_map' => array(
            'admin/layout'           => __DIR__ . '/../view/layout/cms.phtml',
            'admin/404'               => __DIR__ . '/../view/admin/404.phtml',
            'admin/index'             => __DIR__ . '/../view/admin/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    

);


