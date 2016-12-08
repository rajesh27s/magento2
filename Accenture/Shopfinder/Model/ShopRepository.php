<?php

namespace Accenture\Shopfinder\Model;

use Magento\Framework\Api\DataObjectHelper;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Store\Model\StoreManagerInterface;

class ShopRepository implements \Accenture\Shopfinder\Api\ShopRepositoryInterface {

    /**
     * @var \Foggyline\Slider\Model\ResourceModel\Slide
     */
    protected $resource;

    /**
     * @var \Foggyline\Slider\Model\SlideFactory
     */
    protected $shopFactory;

    /**
     * @var \Foggyline\Slider\Model\ResourceModel\Slide\CollectionFactory
     */
    protected $shopCollectionFactory;

    /**
     * @var \Magento\Framework\Api\SearchResultsInterface
     */
    protected $searchResultsFactory;

    /**
     * @var \Magento\Framework\Api\DataObjectHelper
     */
    protected $dataObjectHelper;

    /**
     * @var \Magento\Framework\Reflection\DataObjectProcessor
     */
    protected $dataObjectProcessor;

    /**
     * @var \Foggyline\Slider\Api\Data\SlideInterfaceFactory
     */
    protected $dataShopFactory;

    /**
     * 
     * @param \Accenture\Shopfinder\Model\ResourceModel\Shop $resource
     * @param \Accenture\Shopfinder\Model\ShopFactory $shopFactory
     * @param \Accenture\Shopfinder\Model\ResourceModel\Shop\CollectionFactory $shopCollectionFactory
     * @param \Accenture\Shopfinder\Api\Data\ShopSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param \Accenture\Shopfinder\Api\Data\ShopInterfaceFactory $dataShopFactory
     */
    public function __construct(
    \Accenture\Shopfinder\Model\ResourceModel\Shop $resource,
    \Magento\Store\Model\StoreManagerInterface $storeManager,        
    \Accenture\Shopfinder\Model\ShopFactory $shopFactory, \Accenture\Shopfinder\Model\ResourceModel\Shop\CollectionFactory $shopCollectionFactory, \Accenture\Shopfinder\Api\Data\ShopSearchResultsInterfaceFactory $searchResultsFactory, \Magento\Framework\Api\DataObjectHelper $dataObjectHelper, \Magento\Framework\Reflection\DataObjectProcessor $dataObjectProcessor, \Accenture\Shopfinder\Api\Data\ShopInterfaceFactory $dataShopFactory
    ) {
        $this->resource = $resource;
        $this->shopFactory = $shopFactory;
        $this->shopCollectionFactory = $shopCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->dataShopFactory = $dataShopFactory;
        $this->storeManager = $storeManager;   
    }

    /**
     * Load Page data collection by given search criteria
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Accenture\Shopfinder\Model\ResourceModel\Shop\Collection
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria) {
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);

        $collection = $this->shopCollectionFactory->create();

        foreach ($searchCriteria->getFilterGroups() as $filterGroup) {
            foreach ($filterGroup->getFilters() as $filter) {
                $condition = $filter->getConditionType() ?: 'eq';
               
                if($filter->getConditionType() == 'like'){
                  $checkString = strpos($filter->getValue(), '%');
                    // check % from query string value
                 if($checkString)
                   $collection->addFieldToFilter($filter->getField(), [$condition => "%".$filter->getValue()."%"]);
                }else{
                $collection->addFieldToFilter($filter->getField(), [$condition => $filter->getValue()]);
                    
                }
            }
        }
        //exit;
        
        // Filter Store view from shop collections
        $storeId = $this->storeManager->getStore()->getId();
        $storeCode =  $this->storeManager->getStore()->getCode();
        
        if($storeCode != 'default'){
            $collection->addFieldToFilter('store_id',$storeId);
        }
        
        $searchResults->setTotalCount($collection->getSize());
        #$this->searchResultsFactory->setTotalCount($collection->getSize());
        $sortOrders = $searchCriteria->getSortOrders();
        if ($sortOrders) {
            foreach ($sortOrders as $sortOrder) {
                $collection->addOrder(
                        $sortOrder->getField(), (strtoupper($sortOrder->getDirection()) === 'ASC') ? 'ASC' : 'DESC'
                );
            }
        }
        
        
        $collection->setCurPage($searchCriteria->getCurrentPage());
        $collection->setPageSize($searchCriteria->getPageSize());

        $shops = [];
        /** @var \Foggyline\Slider\Model\Slide $slideModel */
        foreach ($collection as $shopModel) {
            $shopData = $this->dataShopFactory->create();

            $this->dataObjectHelper->populateWithArray(
                    $shopData, $shopModel->getData(), '\Accentrue\Shopfinder\Api\Data\ShopInterface'
            );

            $shops[] = $this->dataObjectProcessor->buildOutputDataArray(
                    $shopData, '\Accenture\Shopfinder\Api\Data\ShopInterface'
            );
        }
        $searchResults->setItems($shops);
        return $searchResults;
    }

    /**
     * Load Page data by given Page Identity
     *
     * @param string $shopId
     * @return Page
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($shopId) {
        $shop = $this->shopFactory->create();
        $this->resource->load($shop, $shopId);
        if (!$shop->getId()) {
            throw new NoSuchEntityException(__('Shop with id %1 does not exist.', $shopId));
        }
        return $shop;
    }

    /**
     * Save Page data
     *
     * @param \Accenture\Shopfinder\Api\Data\ShopInterface $shop
     * @return Page
     * @throws CouldNotSaveException
     */
    public function save(\Accenture\Shopfinder\Api\Data\ShopInterface $shop) {
        try {
            $this->resource->save($shop);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }
        return $shop;
    }

    /**
     * Delete Page
     *
     * @param \Accenture\Shopfinder\Api\Data\ShopInterface $shop
     * @return bool
     * @throws CouldNotDeleteException
     */
    public function delete(\Accenture\Shopfinder\Api\Data\ShopInterface $shop) {
        try {
            $this->resource->delete($shop);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }

    /**
     * Delete Page by given Page Identity
     *
     * @param string $shopId
     * @return bool
     * @throws CouldNotDeleteException
     * @throws NoSuchEntityException
     */
    public function deleteById($shopId) {
        return $this->delete($this->getById($shopId));
    }

}
