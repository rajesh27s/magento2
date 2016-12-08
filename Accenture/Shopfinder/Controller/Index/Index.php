<?php
 
namespace Accenture\Shopfinder\Controller\Index;
 
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Accenture\Shopfinder\Model\ShopFactory;
 
class Index extends Action
{
    /**
     * @var \Tutorial\SimpleNews\Model\NewsFactory
     */
    protected $_modelShopFactory;
 
    /**
     * @param Context $context
     * @param NewsFactory $modelNewsFactory
     */
    public function __construct(
        Context $context,
        ShopFactory $modelShopFactory
    ) {
        parent::__construct($context);
        $this->_modelShopFactory = $modelNewsFactory;
    }
 
    public function execute()
    {
        /**
         * When Magento get your model, it will generate a Factory class
         * for your model at var/generaton folder and we can get your
         * model by this way
         */
        $newsModel = $this->$_modelShopFactory->create();
 
        // Load the item with ID is 1
        $item = $newsModel->load(1);
        var_dump($item->getData());
 
        // Get news collection
        $newsCollection = $newsModel->getCollection();
        // Load all data of collection
        var_dump($newsCollection->getData());
    }
}