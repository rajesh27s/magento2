<?php

namespace Accenture\Shopfinder\Api\Data;

/**
 * @api
 */
interface ShopInterface {

    /**
     * Constants for keys of data array. Identical to the name of the getter in snake case
     */
    const ID = 'shop_id';
    const SHOP_ID = 'shop_id';
    const SHOP_NAME = 'shop_name';
    const SHOP_COUNTRY = 'shop_country';

    /**
     * Get Shop ID
     * @return int|null
     */
    public function getShopId();

    /**
     * Set shop ID
     *
     * @param int $shopId
     * @return $this
     */
    public function setShopId($shopId);

    /**
     * Get Shop Name
     * @return string
     */
    public function getShopName();

    /**
     * Set shop Name
     *
     * @param string $shopName 
     * @return \Accenture\Shopfinder\Api\Data\ShopInterface
     */
    public function setShopName($shopName);

    /**
     * Get Shop Country
     * @return string
     */
    public function getShopCountry();

    /**
     * Set shop country
     *
     * @param string $shopCountry  
     * @return \Accenture\Shopfinder\Api\Data\ShopInterface
     */
    public function setShopCountry($shopCountry);
}
