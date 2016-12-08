<?php

namespace Accenture\Shopfinder\Api;
use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * @api
 */
interface ShopRepositoryInterface {

    /**
     * Retrieve pages matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Accenture\Shopfinder\Api\Data\ShopSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * Retrieve page.
     *
     * @param int $id
     * @return \Accenture\Shopfinder\Api\Data\ShopInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById($id);

    /**
     * Save page.
     *
     * @param \Accenture\Shopfinder\Api\Data\ShopInterface $shop
     * @return \Accenture\Shopfinder\Api\Data\ShopInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function save(\Accenture\Shopfinder\Api\Data\ShopInterface $shop);

    /**
     * Delete page.
     *
     * @param \Accenture\Shopfinder\Api\Data\ShopInterface $shop
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function delete(\Accenture\Shopfinder\Api\Data\ShopInterface $shop);

    /**
     * Delete page by ID.
     *
     * @param int $id
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function deleteById($id);
}
