<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Admin;


use Zend\ModuleManager\ModuleManager;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Router\RouteMatch;


class Module
{

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
    
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    
    public function init(ModuleManager $mm)
    {
        // tells the last module, to have the follwoign rules applied to it
        $mm->getEventManager()->getSharedManager()->attach(__NAMESPACE__, 'dispatch', function($e) {
           
            
            // sets layout
            $e->getTarget()->layout('admin/layout');
            ////////
            
            // restricts access
            if (!$e->getApplication()->getServiceManager()->get('Authentication')->hasIdentity()) {
                
                $match = $e->getRouteMatch();

                // No route match, this is a 404
                if (!$match instanceof RouteMatch) {
                    return;
                }

                // Login route is whitelisted
                if (in_array($match->getMatchedRouteName(), array('login'))) {
                    return;
                }
                
                // login url from login route
                $url = $e->getRouter()->assemble(array(), array('name' => 'login'));

                // redirect response
                $response = $e->getResponse();
                $response->getHeaders()->addHeaderLine('Location', $url);
                $response->setStatusCode(302);

                return $response;
            }
            //////////////////
            
            
        });
    }
    
   
   
   
}
