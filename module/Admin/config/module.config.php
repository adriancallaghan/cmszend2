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
            'Admin\Controller\Admin' => 'Admin\Controller\AdminController',
        ),
    ),



    'router' => array(
        'routes' => array(

            'admin' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/admin[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        '__NAMESPACE__' => 'Admin\Controller', // this was commented out before
                        'controller' => 'Admin',
                        //'controller' => 'Admin\Controller\Admin',
                        'action'     => 'index',
                    ),
                ),
            ),   

        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'admin' => __DIR__ . '/../view',
        ),
    ),
    
    
    'navigation' => array(
        'default' => array(            
            array(
                'label' => 'Admin',
                'route' => 'admin',
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
                ),
            ),
        ),
    ),


);


