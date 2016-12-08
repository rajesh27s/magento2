<?php

namespace Accenture\Shopfinder\Controller\Adminhtml\Shop;

class Index extends \Accenture\Shopfinder\Controller\Adminhtml\Shop {

    /**
     * Shop list.
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute() {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        if ($this->getRequest()->getQuery('ajax')) {
            $resultForward = $this->resultForwardFactory->create();
            $resultForward->forward('grid');
            return $resultForward;
        }

        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Accenture_Shopfinder::shop');
        $resultPage->getConfig()->getTitle()->prepend(__('Shop List'));
        $resultPage->addBreadcrumb(__('Shop List'), __('Shop Lists'));
        return $resultPage;
    }

}
