<?php
namespace Application\Hydrator;

use Zend\Stdlib\Hydrator\ClassMethods;
use ZfcUser\Entity\UserInterface as UserEntityInterface;


use ZfcUser\Mapper\UserHydrator as UH;
use ZfcUser\Mapper\Exception\InvalidArgumentException;
class UserHydrator extends ClassMethods {
    
    /**
     * Extract values from an object
     *
     * @param  object $object
     * @return array
     * @throws Exception\InvalidArgumentException
     */
    public function extract($object)
    {
        if (!$object instanceof UserEntityInterface) {
            throw new InvalidArgumentException('$object must be an instance of ZfcUser\Entity\UserInterface');
        }
        /* @var $object UserInterface*/
        $data = parent::extract($object);
        $data = $this->mapField('id', 'userid', $data);
        return $data;
    }
    
    /**
     * Hydrate $object with the provided $data.
     *
     * @param  array $data
     * @param  object $object
     * @return UserInterface
     * @throws Exception\InvalidArgumentException
     */
    public function hydrate(array $data, $object)
    {
        if (!$object instanceof UserEntityInterface) {
            throw new InvalidArgumentException('$object must be an instance of ZfcUser\Entity\UserInterface');
        }
        $data = $this->mapField('userid', 'id', $data);
        return parent::hydrate($data, $object);
    }
    
    protected function mapField($keyFrom, $keyTo, array $array)
    {
        $array[$keyTo] = $array[$keyFrom];
        unset($array[$keyFrom]);
        return $array;
    }
}