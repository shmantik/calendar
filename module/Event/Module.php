<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Event;

use Event\Model\Event;
use Event\Model\EventClient;
use Event\Model\tableClient;
use Event\Model\tableEvent;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Event\Model\tableEvent' =>  function($sm) {
                    $tableGateway = $sm->get('EventTableGateway');
                    $table = new tableEvent($tableGateway);
                    return $table;
                },
                'Event\Model\tableClient' =>  function($sm) {
                    $tableGateway = $sm->get('ClientTableGateway');
                    $table = new tableClient($tableGateway);
                    return $table;
                },
                'EventTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Event());
                    return new TableGateway('event', $dbAdapter, null, $resultSetPrototype);
                },
                'ClientTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new EventClient());
                    return new TableGateway('client', $dbAdapter, null, $resultSetPrototype);
                },
            ),
        );
    }
}
