<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Event\Controller;

use Event\Form\EventClientForm;
use Event\Model\EventClient;
use http\Client;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class EventController extends AbstractActionController
{
    protected $eventTable;
    protected $clientTable;

    public function registrationAction()
    {
        $form = new EventClientForm();

        $request = $this->getRequest();
        if ($request->isPost()) {
            $client = new EventClient();
            $form->setInputFilter($client->getInputFilter());
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $client->exchangeArray($form->getData());
                $this->getClientTable()->saveClient($client);
            }
        }
        return new ViewModel([
            'form' => $form,
            'events' => $this->getEventTable()->getThisWeekEvents()
        ]);
    }

    public function getEventTable()
    {
        if (!$this->eventTable) {
            $sm = $this->getServiceLocator();
            $this->eventTable = $sm->get('Event\Model\tableEvent');
        }
        return $this->eventTable;
    }

    public function getClientTable()
    {
        if (!$this->clientTable) {
            $sm = $this->getServiceLocator();
            $this->clientTable = $sm->get('Event\Model\tableClient');
        }
        return $this->clientTable;
    }

}
