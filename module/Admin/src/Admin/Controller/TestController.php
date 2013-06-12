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

        
        $debug = new \stdClass();
        
        
        //$debug = $this->getEntityManager()->getRepository('Application\Entity\Album')->findAll();
        $em = $this->getEntityManager();
        
        $commentDao = $em->getRepository('Application\Entity\Comment');
        $comment = $commentDao->find(15);
        $debug->commentToAlbumTitle = $comment->getAlbum()->title;
        
        
        $albumDao = $em->getRepository('Application\Entity\Album');
        $album = $albumDao->find(6);
        $debug->albumToCommentMessage = $album->getComments()->toArray();
        

        $newComment = new \Application\Entity\Comment();
        $newComment->setMessage('A Message')
                ->setAuthor('Author')
                ->setEmail('email@email.co.uk');

        $album->addComment($newComment);
        

        $em->persist($newComment);
        $em->persist($album);
        $em->flush(); 
        
        return new ViewModel(array(
            'debug'     => isset($debug) ? $debug : null
        ));

    }


}
