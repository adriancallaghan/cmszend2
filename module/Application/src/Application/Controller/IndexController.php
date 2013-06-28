<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        $testIds = array();
        
        $albums = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager')
                ->getRepository('Application\Entity\Album')
                ->findAll();

        if (count($albums)>0){
            foreach($albums AS $album){
                $testIds[$album->id] = '';
            }
        } else {
            $testIds = array_fill(1,11,'');
        }
          
        return new ViewModel(array(
            'test_ids' => array_keys($testIds),
            ));
    }
}
