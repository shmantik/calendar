<?php

namespace Event\Model;

use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;

class tableEvent
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }

    public function getThisWeekEvents()
    {
        $rowset = $this->tableGateway->select(function (Select $select) {
            $select->where->between('date',
                date('Y-m-d', strtotime('last monday')),
                date('Y-m-d', strtotime('next sunday'))
            );
        });
        return $rowset;
    }
}