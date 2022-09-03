<?php

namespace Event\Form;

use Zend\Form\Form;

class EventClientForm extends Form
{
    public function __construct() {
        parent::__construct('client-form');
        $this->add(array(
            'name' => 'fio',
            'options' => array(
                'label' => 'ФИО',
            ),
            'type'  => 'Text',
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\Email',
            'name' => 'email',
            'options' => array(
                'label' => 'Email',
            ),
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\Number',
            'name' => 'event_id',
        ));
        $this->add(array(
            'type' => 'Zend\Form\Element\Csrf',
            'name' => 'csrf',
            'options' => array(
                'csrf_options' => array(
                    'timeout' => 600
                )
            )
        ));
    }
}