<?php

namespace Event\Model;

use Zend\Db\TableGateway\TableGateway;

class tableClient
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function getClient($id)
    {
        $id  = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if (!$row) {
            throw new \Exception("Could not find row $id");
        }
        return $row;
    }

    public function saveClient(EventClient $client)
    {
        $data = array(
            'fio' => $client->fio,
            'email' => $client->email,
            'event_id' => $client->event_id,
        );

        $id = (int)$client->id;
        if ($id == 0) {
            $this->tableGateway->insert($data);
        } else {
            if ($this->getClient($id)) {
                $this->tableGateway->update($data, array('id' => $id));
            } else {
                throw new \Exception('Form id does not exist');
            }
        }
    }
}