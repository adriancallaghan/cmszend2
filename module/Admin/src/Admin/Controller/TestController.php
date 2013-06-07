<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController,
Zend\View\Model\ViewModel,
Doctrine\ORM\EntityManager;

class TestController extends AbstractActionController
{

    /**            
    * @var Doctrine\ORM\EntityManager
    */                
    protected $_em;
    
    public function setEntityManager(EntityManager $em = null)
    {
        if ($em===null){
            $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        }
        $this->_em = $em;
        return $this;
    }
    
    public function getEntityManager()
    {
        if (!isset($this->_em)) {
            $this->setEntityManager();
        }
        return $this->_em;
    } 
    
    
    public function indexAction()
    {

        $debug = null;
        
        $debug = $this->getEntityManager()->getRepository('Application\Entity\Album')->findAll();
        
        
        
        return new ViewModel(array(
            'debug'     => $debug
        ));

    }


}
