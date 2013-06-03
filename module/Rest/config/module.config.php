<?php
    return array(
        'controllers' => array(
            'invokables' => array(
                'Rest\Controller\Rest' => 'Rest\Controller\RestController',
            ),
        ),

        'router' => array(
            'routes' => array(
                'rest' => array(
                    'type' => 'segment',
                    'options' => array(
                        'route' => '/rest[/:id]',
                        'constraints' => array(
                            'id' => '[0-9]+',
                        ),
                        'defaults' => array(
                            'controller' => 'Rest\Controller\Rest',
                        ),
                    ),
                ),
            ),
        ),

        'view_manager' => array(
            'template_path_stack' => array(
                __DIR__ . '/../view',
            ),
            'strategies' => array(
                'ViewJsonStrategy',
            ),
        ),
        
    );