<?php

namespace Event\Model;

use Zend\InputFilter\Factory;
use Zend\InputFilter\InputFilter;

class EventClient
{
    public $id;
    public $event_id;
    public $fio;
    public $email;
    protected $inputFilter;

    public function exchangeArray($data) {
        $this->id     = (isset($data['id'])) ? $data['id'] : null;
        $this->event_id     = (isset($data['event_id'])) ? $data['event_id'] : null;
        $this->fio  = (isset($data['fio'])) ? $data['fio'] : null;
        $this->email  = (isset($data['email'])) ? $data['email'] : null;
    }

    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory     = new Factory();

            $inputFilter->add($factory->createInput(array(
                'name'     => 'event_id',
                'required' => true,
                'filters'  => array(
                    array('name' => 'Int'),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name'     => 'email',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 45,
                        ),
                    ),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name'     => 'fio',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 100,
                        ),
                    ),
                ),
            )));

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }
}