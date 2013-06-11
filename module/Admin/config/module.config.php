<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */




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
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/admin[/:action][/]',
                    'defaults' => array(
                        'controller' => 'Admin\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'login' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => 'login',
                            'defaults' => array(
                                'action' => 'login'
                            )
                        )
                    ),
                    'logout' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => 'logout',
                            'defaults' => array(
                                'action' => 'logout'
                            )
                        )
                    )
                ),
            ),        
            'album' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/admin/album[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Admin\Controller', 
                        'controller' => 'Album',
                        'action'     => 'index',
                    ),
                ),
            ), 
            'test' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/admin/test[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Admin\Controller', 
                        'controller' => 'Test',
                        'action'     => 'index',
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
                'route' => 'album',
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
                'route' => 'test'
            )
        ),
    ),
    
    
    'service_manager' => array(
        
        /*
        'Admin\Authentication\Service' => function($sm) {
            $authService = new \Zend\Authentication\AuthenticationService();
            $authService->setStorage(new \Zend\Authentication\Storage\Session('user', 'details'));
            return $authService;
        },*/
        'factories' => array(
            'admin_navigation' => 'Admin\Navigation\Service\AdminNavigationFactory',  
            'Zend\Authentication\AuthenticationService' => function($serviceManager) {
                return $serviceManager->get('doctrine.authenticationservice.orm_default');
            }
        ),
        'services' => array(
            //'Zend\Authentication\AuthenticationService' => new Zend\Authentication\AuthenticationService(),
            /*'authenticationadapter' => array(
                'odm_default' => array(
                    'objectManager' => 'doctrine.documentmanager.odm_default',
                    'identityClass' => 'Application\Entity\User',
                    'identityProperty' => 'username',
                    'credentialProperty' => 'password',
                    //'credentialCallable' => 'Application\Entity\User::hashPassword'
                ),
            ),*/
        )
    ),
    
    
    
    
    'doctrine' => array(
        'authentication' => array(
            'orm_default' => array(
                'object_manager' => 'Doctrine\ORM\EntityManager',
                'identity_class' => 'Application\Entity\User',
                'identity_property' => '_username',
                'credential_property' => 'password',
            ),
        ),
    ),


    'view_manager' => array(
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


