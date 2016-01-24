<?php

namespace Admin;

 use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
 use Zend\ModuleManager\Feature\ConfigProviderInterface;
 use Admin\Model\Serie;
 use Admin\Model\SerieTable;
 use Zend\Db\ResultSet\ResultSet;
 use Zend\Db\TableGateway\TableGateway;


 class Module implements AutoloaderProviderInterface, ConfigProviderInterface
 {
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

     public function getConfig()
     {
         return include __DIR__ . '/config/module.config.php';
     }

     // Add this method:
     public function getServiceConfig()
     {
         return array(
             'factories' => array(
                 'Admin\Model\SerieTable' =>  function($sm) {
                     $tableGateway = $sm->get('SerieTableGateway');
                     $table = new SerieTable($tableGateway);
                     return $table;
                 },
                 'SerieTableGateway' => function ($sm) {
                     $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                     $resultSetPrototype = new ResultSet();
                     $resultSetPrototype->setArrayObjectPrototype(new Serie());
                     return new TableGateway('serie', $dbAdapter, null, $resultSetPrototype);
                 },
             ),
         );
     }

 }