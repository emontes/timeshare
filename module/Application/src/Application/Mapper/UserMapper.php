<?php
namespace Application\Mapper;

use ZfcUser\Entity\User;
use Zend\Stdlib\Hydrator\HydratorInterface;
class UserMapper extends \ZfcUser\Mapper\User {
    
    
    public function findById($id)
    {
        $select = $this->getSelect()
        ->where(array('userid' => $id));
    
        $entity = $this->select($select)->current();
        $this->getEventManager()->trigger('find', $this, array('entity' => $entity));
        return $entity;
    }
    
    public function update($entity, $where = null, $tableName = null, HydratorInterface $hydrator = null)
    {
        if (!$where) {
            $where = 'userid = ' . $entity->getId();
        }
    
        return parent::update($entity, $where, $tableName, $hydrator);
    }
    
    public function insert($entity, $tableName = null, HydratorInterface $hydrator = null)
    {
        $result = parent::insert($entity, $tableName, $hydrator);
        $entity->setId($result->getGeneratedValue());
        return $result;
    }
}