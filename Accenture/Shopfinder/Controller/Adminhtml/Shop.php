<?php

namespace Accenture\Shopfinder\Controller\Adminhtml;

abstract class Shop extends \Magento\Backend\App\Action {

    protected $resultPageFactory;
    protected $resultForwardFactory;
    protected $resultRedirectFactory;
    
    protected $_shopFactory;
    

    public function __construct(
    \Magento\Backend\App\Action\Context $context, 
    \Magento\Framework\Registry $registry, 
    \Magento\Framework\Stdlib\DateTime\Filter\Date $dateFilter, 
    \Magento\Framework\View\Result\PageFactory $resultPageFactory, 
    \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory
   // \Accenture\Shopfinder\Model\ShopFactory $shopFactory
    ) {
        $this->_coreRegistry = $registry;
        //$this->_shopFactory = $shopFactory;
        $this->resultPageFactory = $resultPageFactory;
        $this->resultForwardFactory = $resultForwardFactory;
        $this->resultRedirectFactory = $context->getResultRedirectFactory();

        parent::__construct($context);
    }

//    protected function _isAllowed() {
//        return $this->_authorization->isAllowed('Accenture_Shopfinder::Shop');
//    }

    protected function _initAction() {
        $this->_view->loadLayout();
        $this->_setActiveMenu(
                'Accenture_Shopfinder::shop'
        )->_addBreadcrumb(
                __('Shopfinder'), __('Shop')
        );
       
        return $this;
    }

}
