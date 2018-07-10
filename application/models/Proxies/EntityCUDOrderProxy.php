<?php

namespace Proxies;

/**
 * THIS CLASS WAS GENERATED BY THE DOCTRINE ORM. DO NOT EDIT THIS FILE.
 */
class EntityCUDOrderProxy extends \Entity\CUDOrder implements \Doctrine\ORM\Proxy\Proxy
{
    private $_entityPersister;
    private $_identifier;
    public $__isInitialized__ = false;
    public function __construct($entityPersister, $identifier)
    {
        $this->_entityPersister = $entityPersister;
        $this->_identifier = $identifier;
    }
    private function _load()
    {
        if (!$this->__isInitialized__ && $this->_entityPersister) {
            $this->__isInitialized__ = true;
            if ($this->_entityPersister->load($this->_identifier, $this) === null) {
                throw new \Doctrine\ORM\EntityNotFoundException();
            }
            unset($this->_entityPersister, $this->_identifier);
        }
    }

    
    public function setCuId(\Entity\CUnit $cuId)
    {
        $this->_load();
        return parent::setCuId($cuId);
    }

    public function getCuId()
    {
        $this->_load();
        return parent::getCuId();
    }

    public function setStoreId(\Entity\Area $store_id)
    {
        $this->_load();
        return parent::setStoreId($store_id);
    }

    public function getStoreId()
    {
        $this->_load();
        return parent::getStoreId();
    }

    public function setApartmentStoreId(\Entity\Apartment $apartment_store_id)
    {
        $this->_load();
        return parent::setApartmentStoreId($apartment_store_id);
    }

    public function getApartmentStoreId()
    {
        $this->_load();
        return parent::getApartmentStoreId();
    }

    public function setCUOrder(\Entity\CUOrderDetails $cuOrderDetail)
    {
        $this->_load();
        return parent::setCUOrder($cuOrderDetail);
    }

    public function getCUOrders()
    {
        $this->_load();
        return parent::getCUOrders();
    }

    public function setEmployeeId(\Entity\Employee $emp_id)
    {
        $this->_load();
        return parent::setEmployeeId($emp_id);
    }

    public function getEmployeeId()
    {
        $this->_load();
        return parent::getEmployeeId();
    }

    public function setCUEmployeeId(\Entity\CUEmployee $cue_id)
    {
        $this->_load();
        return parent::setCUEmployeeId($cue_id);
    }

    public function getCUEmployeeId()
    {
        $this->_load();
        return parent::getCUEmployeeId();
    }

    public function getId()
    {
        $this->_load();
        return parent::getId();
    }

    public function setOrderId($order_id)
    {
        $this->_load();
        return parent::setOrderId($order_id);
    }

    public function getOrderId()
    {
        $this->_load();
        return parent::getOrderId();
    }

    public function setMessage($message)
    {
        $this->_load();
        return parent::setMessage($message);
    }

    public function getMessage()
    {
        $this->_load();
        return parent::getMessage();
    }

    public function setStatus($status)
    {
        $this->_load();
        return parent::setStatus($status);
    }

    public function getStatus()
    {
        $this->_load();
        return parent::getStatus();
    }

    public function setCreatedAt($created_at)
    {
        $this->_load();
        return parent::setCreatedAt($created_at);
    }

    public function getCreatedAt()
    {
        $this->_load();
        return parent::getCreatedAt();
    }

    public function setUpdatedAt($updated_at)
    {
        $this->_load();
        return parent::setUpdatedAt($updated_at);
    }

    public function getUpdatedAt()
    {
        $this->_load();
        return parent::getUpdatedAt();
    }


    public function __sleep()
    {
        return array('__isInitialized__', 'id', 'order_id', 'message', 'status', 'emp_id', 'cue_id', 'cu_id', 'store_id', 'apartment_store_id', 'cuOrderDetails', 'updated_at', 'created_at');
    }
}