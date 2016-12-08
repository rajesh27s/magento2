<?php
 
namespace Accenture\Shopfinder\Controller\Adminhtml\Shop;
 
use Accenture\Shopfinder\Controller\Adminhtml\Shop;
 
class Grid extends Shop
{
   /**
     * @return void
     */
   public function execute()
   {
      return $this->_resultPageFactory->create();
   }
}