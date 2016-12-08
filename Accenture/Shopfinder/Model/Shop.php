<?php

namespace Accenture\Shopfinder\Model;

use Magento\Framework\Model\AbstractModel;
use Accenture\Shopfinder\Api\Data\ShopInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Exception\LocalizedException;

class Shop extends AbstractModel implements ShopInterface {

    const BASE_MEDIA_PATH = 'shopfinder/shop/image';

    protected function _construct() {
        $this->_init('Accenture\Shopfinder\Model\ResourceModel\Shop');
    }

    public function setShopId($shopId) {
        return $this->setData(self::SHOP_ID, $shopId);
    }

    public function setShopName($shopName) {
        return $this->setData(self::SHOP_NAME, $shopName);
    }

    public function setShopCountry($shopCountry) {
        return $this->setData(self::SHOP_COUNTRY, $shopCountry);
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getShopId() {
        return $this->getData(self::SHOP_ID);
    }

    public function getShopName() {
        return $this->getData(self::SHOP_NAME);
    }

    public function getShopCountry() {
        return $this->getData(self::SHOP_COUNTRY);
    }

}
