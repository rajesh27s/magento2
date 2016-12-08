<?php

namespace Accenture\Shopfinder\Model\ResourceModel\Shop;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection {

    /**
     * @var string
     */
    protected $_idFieldName = 'shop_id';

    protected function _construct() {
        $this->_init('Accenture\Shopfinder\Model\Shop', 'Accenture\Shopfinder\Model\ResourceModel\Shop');
    }

}
