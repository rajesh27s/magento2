<?php
 
namespace Accenture\Shopfinder\Controller\Adminhtml\Shop;
 
use Accenture\Shopfinder\Controller\Adminhtml\Shop;
 
class Delete extends Shop
{
   /**
    * @return void
    */
   public function execute()
   {
      $shopId = (int) $this->getRequest()->getParam('id');
 
      if ($shopId) {
         /** @var $newshopModel Accenture\Shopfinder\Model\News */
         $shopModel = $this->_shopFactory->create();
         $shopModel->load($shopId);
 
         // Check this news exists or not
         if (!$shopModel->getId()) {
            $this->messageManager->addError(__('This news no longer exists.'));
         } else {
               try {
                  // Delete news
                  $shopModel->delete();
                  $this->messageManager->addSuccess(__('The news has been deleted.'));
 
                  // Redirect to grid page
                  $this->_redirect('*/*/');
                  return;
               } catch (\Exception $e) {
                   $this->messageManager->addError($e->getMessage());
                   $this->_redirect('*/*/edit', ['id' => $shopModel->getId()]);
               }
            }
      }
   }
}