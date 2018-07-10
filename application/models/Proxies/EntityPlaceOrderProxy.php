<?php

namespace Proxies;

/**
 * THIS CLASS WAS GENERATED BY THE DOCTRINE ORM. DO NOT EDIT THIS FILE.
 */
class EntityPlaceOrderProxy extends \Entity\PlaceOrder implements \Doctrine\ORM\Proxy\Proxy
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

    
    public function addPlaceOrderAddon(\Entity\PlaceOrderAddon $placeOrderAddon)
    {
        $this->_load();
        return parent::addPlaceOrderAddon($placeOrderAddon);
    }

    public function getPlaceOrderAddons()
    {
        $this->_load();
        return parent::getPlaceOrderAddons();
    }

    public function removePlaceOrderAddons()
    {
        $this->_load();
        return parent::removePlaceOrderAddons();
    }

    public function getProcessOrders()
    {
        $this->_load();
        return parent::getProcessOrders();
    }

    public function getProcessOrdersOnly()
    {
        $this->_load();
        return parent::getProcessOrdersOnly();
    }

    public function setItemId(\Entity\Item $item_id = NULL)
    {
        $this->_load();
        return parent::setItemId($item_id);
    }

    public function getItemId()
    {
        $this->_load();
        return parent::getItemId();
    }

    public function setServiceId(\Entity\Service $service_id = NULL)
    {
        $this->_load();
        return parent::setServiceId($service_id);
    }

    public function getServiceId()
    {
        $this->_load();
        return parent::getServiceId();
    }

    public function setCustomerId(\Entity\Customer $cust_id = NULL)
    {
        $this->_load();
        return parent::setCustomerId($cust_id);
    }

    public function getCustomerId()
    {
        $this->_load();
        return parent::getCustomerId();
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

    public function getId()
    {
        $this->_load();
        return parent::getId();
    }

    public function setIcount($icount)
    {
        $this->_load();
        return parent::setIcount($icount);
    }

    public function getIcount()
    {
        $this->_load();
        return parent::getIcount();
    }

    public function addRIcount()
    {
        $this->_load();
        return parent::addRIcount();
    }

    public function subsRIcount()
    {
        $this->_load();
        return parent::subsRIcount();
    }

    public function setRIcount($ricount)
    {
        $this->_load();
        return parent::setRIcount($ricount);
    }

    public function getRIcount()
    {
        $this->_load();
        return parent::getRIcount();
    }

    public function addHIcount()
    {
        $this->_load();
        return parent::addHIcount();
    }

    public function subsHIcount()
    {
        $this->_load();
        return parent::subsHIcount();
    }

    public function setHIcount($hicount)
    {
        $this->_load();
        return parent::setHIcount($hicount);
    }

    public function getHIcount()
    {
        $this->_load();
        return parent::getHIcount();
    }

    public function getItemCount()
    {
        $this->_load();
        return parent::getItemCount();
    }

    public function setCost($cost)
    {
        $this->_load();
        return parent::setCost($cost);
    }

    public function getCost()
    {
        $this->_load();
        return parent::getCost();
    }

    public function setReFund($reFund)
    {
        $this->_load();
        return parent::setReFund($reFund);
    }

    public function addReFund($reFund)
    {
        $this->_load();
        return parent::addReFund($reFund);
    }

    public function getReFund()
    {
        $this->_load();
        return parent::getReFund();
    }

    public function setRpoints($rpoints)
    {
        $this->_load();
        return parent::setRpoints($rpoints);
    }

    public function getRpoints()
    {
        $this->_load();
        return parent::getRpoints();
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
        return array('__isInitialized__', 'id', 'order_id', 'icount', 'ricount', 'hicount', 'cost', 'reFund', 'rpoints', 'status', 'updated_at', 'created_at', 'item_id', 'service_id', 'cust_id', 'placeOrderAddons', 'processOrders');
    }
}