<?php
namespace Accenture\Shopfinder\Model\ResourceModel;
class Shop extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
protected function _construct(){
$this->_init('shop', 'shop_id');
  }
}