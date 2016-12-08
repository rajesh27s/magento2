<?php

namespace Accenture\Shopfinder\Block\Adminhtml;

class Shop extends \Magento\Backend\Block\Widget\Grid\Container {

    protected function _construct() {

        
        $this->_controller = 'adminhtml_shop';
        $this->_blockGroup = 'Accenture_Shopfinder';
        $this->_headerText = __('Shop');
        $this->_headerText = __('Shop');
        parent::_construct();
    }

}
