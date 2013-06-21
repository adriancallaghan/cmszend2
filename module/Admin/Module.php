<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Admin;


use Zend\Loader;
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
            Loader\AutoloaderFactory::STANDARD_AUTOLOADER => array(
                Loader\StandardAutoloader::LOAD_NS => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    
    
    
    public function init(ModuleManager $mm)
    {
        // tells the last module, to have the following rules applied to it
        $mm->getEventManager()->getSharedManager()->attach(__NAMESPACE__, 'dispatch', function($e) {
           
            //var_dump($e->getResponse()->getStatusCode());

            // change layout
            $e->getTarget()->layout('admin/layout');
            //////////////////
            
            // restricts access
            $this->restrictAccess($e);
            //////////////////
            
            
        });
    }
    
    
    
    
    public function restrictAccess(MvcEvent $e, array $whiteListed = array(), $loginRouteName = 'admin/login'){
        
        // $loginRouteName is whitelisted from the redirection
        // The redirection is to the $loginRouteName 
        // additional routes can be whitelisted        
        if (!$e->getApplication()->getServiceManager()->get('Zend\Authentication\AuthenticationService')->hasIdentity()) {
                
            $whiteListed[] = $loginRouteName;

            $match = $e->getRouteMatch();

            // No route match, this is a 404
            if (!$match instanceof RouteMatch) {
                return;
            }

            // Login route is whitelisted
            if (in_array($match->getMatchedRouteName(), $whiteListed)) {
                return;
            }

            // login url from login route
            $url = $e->getRouter()->assemble(array(), array('name' => $loginRouteName));

            // redirect response
            $response = $e->getResponse();
            $response->getHeaders()->addHeaderLine('Location', $url);
            $response->setStatusCode(302);
            $response->sendHeaders();
            exit;
        }
        
    }
    
   
   
}
