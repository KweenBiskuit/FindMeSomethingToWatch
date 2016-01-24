<?php 

 namespace Admin\Controller;

 use Zend\Mvc\Controller\AbstractActionController;
 use Zend\View\Model\ViewModel;

 class AdminController extends AbstractActionController
 {
 	 protected $serieTable;

     public function indexAction()
     {
         return new ViewModel(array(
             'series' => $this->getSerieTable()->fetchAll(),
         ));
     }

     public function addAction()
     {
     }

     public function editAction()
     {
     }

     public function deleteAction()
     {
     }

     public function getSerieTable()
     {
         if (!$this->serieTable) {
             $sm = $this->getServiceLocator();
             $this->serieTable = $sm->get('Admin\Model\SerieTable');
         }
         return $this->serieTable;
     }


 }