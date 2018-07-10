<?php

namespace Proxies;

/**
 * THIS CLASS WAS GENERATED BY THE DOCTRINE ORM. DO NOT EDIT THIS FILE.
 */
class EntityPlaceOrderIdProxy extends \Entity\PlaceOrderId implements \Doctrine\ORM\Proxy\Proxy
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

    
    public function setCouponCode($couponCode)
    {
        $this->_load();
        return parent::setCouponCode($couponCode);
    }

    public function getCouponCode()
    {
        $this->_load();
        return parent::getCouponCode();
    }

    public function setProcessDelayInDays($processDelayInDays)
    {
        $this->_load();
        return parent::setProcessDelayInDays($processDelayInDays);
    }

    public function getProcessDelayInDays()
    {
        $this->_load();
        return parent::getProcessDelayInDays();
    }

    public function setVendorId($vendorId)
    {
        $this->_load();
        return parent::setVendorId($vendorId);
    }

    public function getVendorId()
    {
        $this->_load();
        return parent::getVendorId();
    }

    public function setQd($qd)
    {
        $this->_load();
        return parent::setQd($qd);
    }

    public function getQd()
    {
        $this->_load();
        return parent::getQd();
    }

    public function setQdPercent($qdPercent)
    {
        $this->_load();
        return parent::setQdPercent($qdPercent);
    }

    public function getQdPercent()
    {
        $this->_load();
        return parent::getQdPercent();
    }

    public function setQdAmount($qdAmount)
    {
        $this->_load();
        return parent::setQdAmount($qdAmount);
    }

    public function getQdAmount()
    {
        $this->_load();
        return parent::getQdAmount();
    }

    public function setIsDelete($isDelete)
    {
        $this->_load();
        return parent::setIsDelete($isDelete);
    }

    public function getIsDelete()
    {
        $this->_load();
        return parent::getIsDelete();
    }

    public function setIsPackageOrder($isPackageOrder)
    {
        $this->_load();
        return parent::setIsPackageOrder($isPackageOrder);
    }

    public function getIsPackageOrder($isPackageOrder)
    {
        $this->_load();
        return parent::getIsPackageOrder($isPackageOrder);
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

    public function setTotalItems($totalItems)
    {
        $this->_load();
        return parent::setTotalItems($totalItems);
    }

    public function getTotalItems()
    {
        $this->_load();
        return parent::getTotalItems();
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

    public function getCUOrderDetails()
    {
        $this->_load();
        return parent::getCUOrderDetails();
    }

    public function setSubtotal($subtotal)
    {
        $this->_load();
        return parent::setSubtotal($subtotal);
    }

    public function getSubtotal()
    {
        $this->_load();
        return parent::getSubtotal();
    }

    public function setServiceTax($serviceTax)
    {
        $this->_load();
        return parent::setServiceTax($serviceTax);
    }

    public function getServiceTax()
    {
        $this->_load();
        return parent::getServiceTax();
    }

    public function setTotalAmount($totalAmount)
    {
        $this->_load();
        return parent::setTotalAmount($totalAmount);
    }

    public function getTotalAmount()
    {
        $this->_load();
        return parent::getTotalAmount();
    }

    public function setReFundAmount($reFundAmount)
    {
        $this->_load();
        return parent::setReFundAmount($reFundAmount);
    }

    public function addReFundAmount($reFundAmount)
    {
        $this->_load();
        return parent::addReFundAmount($reFundAmount);
    }

    public function getReFundAmount()
    {
        $this->_load();
        return parent::getReFundAmount();
    }

    public function setClosingBalance($closingBalance)
    {
        $this->_load();
        return parent::setClosingBalance($closingBalance);
    }

    public function getClosingBalance()
    {
        $this->_load();
        return parent::getClosingBalance();
    }

    public function getClosingAmount()
    {
        $this->_load();
        return parent::getClosingAmount();
    }

    public function setRedeemAmount($redeemAmount)
    {
        $this->_load();
        return parent::setRedeemAmount($redeemAmount);
    }

    public function addRedeemAmount($redeemAmount)
    {
        $this->_load();
        return parent::addRedeemAmount($redeemAmount);
    }

    public function getRedeemAmount()
    {
        $this->_load();
        return parent::getRedeemAmount();
    }

    public function setRPointsUsed($rPointsUsed)
    {
        $this->_load();
        return parent::setRPointsUsed($rPointsUsed);
    }

    public function getRPointsUsed()
    {
        $this->_load();
        return parent::getRPointsUsed();
    }

    public function setAdminDiscount($adminDiscount)
    {
        $this->_load();
        return parent::setAdminDiscount($adminDiscount);
    }

    public function getAdminDiscount()
    {
        $this->_load();
        return parent::getAdminDiscount();
    }

    public function setAdminDiscountAmount($adminDiscountAmount)
    {
        $this->_load();
        return parent::setAdminDiscountAmount($adminDiscountAmount);
    }

    public function getAdminDiscountAmount()
    {
        $this->_load();
        return parent::getAdminDiscountAmount();
    }

    public function setOrderDate($orderDate)
    {
        $this->_load();
        return parent::setOrderDate($orderDate);
    }

    public function getOrderDate()
    {
        $this->_load();
        return parent::getOrderDate();
    }

    public function setOrdSrc($ordSrc)
    {
        $this->_load();
        return parent::setOrdSrc($ordSrc);
    }

    public function getOrdSrc()
    {
        $this->_load();
        return parent::getOrdSrc();
    }

    public function setDeliveryDate($deliveryDate)
    {
        $this->_load();
        return parent::setDeliveryDate($deliveryDate);
    }

    public function getDeliveryDate()
    {
        $this->_load();
        return parent::getDeliveryDate();
    }

    public function setPaidAmount($paidAmount)
    {
        $this->_load();
        return parent::setPaidAmount($paidAmount);
    }

    public function getPaidAmount()
    {
        $this->_load();
        return parent::getPaidAmount();
    }

    public function setPaymentType($paymentType)
    {
        $this->_load();
        return parent::setPaymentType($paymentType);
    }

    public function getPaymentType()
    {
        $this->_load();
        return parent::getPaymentType();
    }

    public function setTransactionNumber($transactionNumber)
    {
        $this->_load();
        return parent::setTransactionNumber($transactionNumber);
    }

    public function getTransactionNumber()
    {
        $this->_load();
        return parent::getTransactionNumber();
    }

    public function setPaymentFeedback($paymentFeedback)
    {
        $this->_load();
        return parent::setPaymentFeedback($paymentFeedback);
    }

    public function getPaymentFeedback()
    {
        $this->_load();
        return parent::getPaymentFeedback();
    }

    public function setBalanceAmount($balanceAmount)
    {
        $this->_load();
        return parent::setBalanceAmount($balanceAmount);
    }

    public function getBalanceAmount()
    {
        $this->_load();
        return parent::getBalanceAmount();
    }

    public function setFirstPaidAmount($firstPaidAmount)
    {
        $this->_load();
        return parent::setFirstPaidAmount($firstPaidAmount);
    }

    public function getFirstPaidAmount()
    {
        $this->_load();
        return parent::getFirstPaidAmount();
    }

    public function setSecondPaidAmount($secondPaidAmount)
    {
        $this->_load();
        return parent::setSecondPaidAmount($secondPaidAmount);
    }

    public function getSecondPaidAmount()
    {
        $this->_load();
        return parent::getSecondPaidAmount();
    }

    public function setThirdPaidAmount($thirdPaidAmount)
    {
        $this->_load();
        return parent::setThirdPaidAmount($thirdPaidAmount);
    }

    public function getThirdPaidAmount()
    {
        $this->_load();
        return parent::getThirdPaidAmount();
    }

    public function setCustomerId(\Entity\Customer $customer_id)
    {
        $this->_load();
        return parent::setCustomerId($customer_id);
    }

    public function getCustomerId()
    {
        $this->_load();
        return parent::getCustomerId();
    }

    public function setPickupBoyId(\Entity\PickupBoy $pb_id)
    {
        $this->_load();
        return parent::setPickupBoyId($pb_id);
    }

    public function getPickupBoyId()
    {
        $this->_load();
        return parent::getPickupBoyId();
    }

    public function setDeliveryBoyId(\Entity\PickupBoy $db_id)
    {
        $this->_load();
        return parent::setDeliveryBoyId($db_id);
    }

    public function getDeliveryBoyId()
    {
        $this->_load();
        return parent::getDeliveryBoyId();
    }

    public function setAddressId($address_id)
    {
        $this->_load();
        return parent::setAddressId($address_id);
    }

    public function getAddressId()
    {
        $this->_load();
        return parent::getAddressId();
    }

    public function getId()
    {
        $this->_load();
        return parent::getId();
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

    public function setOrderStatus($poStatus)
    {
        $this->_load();
        return parent::setOrderStatus($poStatus);
    }

    public function getOrderStatus()
    {
        $this->_load();
        return parent::getOrderStatus();
    }

    public function setOrderStatusMessage($poStatusMessage)
    {
        $this->_load();
        return parent::setOrderStatusMessage($poStatusMessage);
    }

    public function getOrderStatusMessage()
    {
        $this->_load();
        return parent::getOrderStatusMessage();
    }

    public function setPickupBoyStatus($pstatus)
    {
        $this->_load();
        return parent::setPickupBoyStatus($pstatus);
    }

    public function getPickupBoyStatus()
    {
        $this->_load();
        return parent::getPickupBoyStatus();
    }

    public function setCuStatus($status)
    {
        $this->_load();
        return parent::setCuStatus($status);
    }

    public function getCuStatus()
    {
        $this->_load();
        return parent::getCuStatus();
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
        return array('__isInitialized__', 'id', 'order_id', 'subtotal', 'qd', 'qdPercent', 'qdAmount', 'serviceTax', 'totalAmount', 'redeemAmount', 'rPointsUsed', 'balanceAmount', 'paidAmount', 'paymentType', 'transactionNumber', 'paymentFeedback', 'reFundAmount', 'closingBalance', 'adminDiscount', 'totalItems', 'adminDiscountAmount', 'couponCode', 'orderDate', 'ordSrc', 'deliveryDate', 'processDelayInDays', 'firstPaidAmount', 'secondPaidAmount', 'thirdPaidAmount', 'status', 'isDelete', 'isPackageOrder', 'poStatus', 'poStatusMessage', 'pickupBoyStatus', 'cuStatus', 'customer_id', 'pb_id', 'db_id', 'address_id', 'store_id', 'cuOrderDetails', 'updated_at', 'created_at', 'vendorId');
    }
}