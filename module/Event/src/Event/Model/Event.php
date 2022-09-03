<?php

namespace Event\Model;

class Event
{
    public $id;
    public $title;
    public $description;
    public $date;

    public function exchangeArray($data) {
        $this->id     = (isset($data['id'])) ? $data['id'] : null;
        $this->title  = (isset($data['title'])) ? $data['title'] : null;
        $this->description  = (isset($data['description'])) ? $data['description'] : null;
        $this->date  = (isset($data['date'])) ? $data['date'] : null;
    }
}