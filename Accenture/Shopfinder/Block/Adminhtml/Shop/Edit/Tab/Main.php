<?php
namespace Accenture\Shopfinder\Block\Adminhtml\Shop\Edit\Tab;

class Main extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface {

    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $_systemStore;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Magento\Store\Model\System\Store $systemStore
     * @param array $data
     */
    public function __construct(
    \Magento\Backend\Block\Template\Context $context, \Magento\Framework\Registry $registry, \Magento\Framework\Data\FormFactory $formFactory, 
    \Accenture\Shopfinder\Model\Shop\Source\Country $listCountry, 
    \Accenture\Shopfinder\Model\Status $shopOptions,
    \Magento\Cms\Model\Wysiwyg\Config $wysiwygConfig,
    \Magento\Store\Model\System\Store $systemStore, array $data = []
    ) {
        $this->_systemStore = $systemStore;
        $this->_countryStore = $listCountry;
        $this->_shopStatus =  $shopOptions;
        $this->_wysiwygConfig = $wysiwygConfig;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare form
     *
     * @return $this
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    protected function _prepareForm() {
       
        $model = $this->_coreRegistry->registry('shop_data');
        $isElementDisabled = false;
        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();
       // $form->setHtmlIdPrefix('page_');
        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('General Information')]);
        if ($model->getId()) {
            $fieldset->addField('shop_id', 'hidden', ['name' => 'shop_id']);
        }
       
           
        $fieldset->addField(
            'shop_name',
            'text',
            [
                'name'        => 'shop_name',
                'label'    => __('Shop Name'),
                'required'     => true
            ]
        );
        
         $fieldset->addField(
            'shop_identifier',
            'text',
            [
                'name'        => 'shop identifier',
                'label'    => __('Shop Identifier'),
                'required'     => false
            ]
        );
         
        $fieldset->addField(
            'shop_address',
            'text',
            [
                'name'        => 'shop address',
                'label'    => __('Address'),
                'required'     => true
            ]
        );
         
        $fieldset->addField(
            'shop_address1',
            'text',
            [
                'name'        => 'shop address1',
                'label'    => __(''),
                'required'     => false
            ]
        );
        
        $fieldset->addField(
            'shop_city',
            'text',
            [
                'name'        => 'shop city',
                'label'    => __('City'),
                'required'     => false
            ]
        );
        
        $fieldset->addField(
            'shop_state',
            'text',
            [
                'name'        => 'shop state',
                'label'    => __('State/Province'),
                'required'     => false
            ]
        );
        
        $fieldset->addField(
            'shop_postal',
            'text',
            [
                'name'        => 'shop postal',
                'label'    => __('Postal \ Zipcode'),
                'required'     => true
            ]
        );
        
        $fieldset->addField(
            'shop_phone',
            'text',
            [
                'name'        => 'shop phone',
                'label'    => __('Phone'),
                'required'     => false
            ]
        );
        
        $fieldset->addField(
            'shop_email',
            'text',
            [
                'name'        => 'shop email',
                'label'    => __('Email'),
                'required'     => false
            ]
        );
        
         $fieldset->addField(
            'shop_status',
            'select',
            [
                'name'      => 'shop status',
                'label'     => __('Status'),
                'options'   => $this->_shopStatus->getOptionArray(),
                'required'     => true
            ]
        );
         
        $fieldset->addField(
            'shop_collect',
            'select',
            [
                'name'      => 'shop collect',
                'label'     => __('Can Collect'),
                'options'   => $this->_shopStatus->getOptionArray(),
                'required'     => true
            ]
        );
         
         $optionsc = $this->_countryStore->toOptionArray();
         
           $fieldset->addField(
                'shop_country',
                'select',
                [
                    'name' => 'shop country',
                    'label' => __('Country'),
                    'title' => __('Country'),
               // 'onchange' => 'getstate(this)',
                    'values' => $optionsc,
                    'required'     => true,
                ]
                    
            );
            
        
        $fieldset->addField(
            'shop_image',
            'image',
            [
                'title' => __('shop image'),
                'label' => __('Shop Image'),
                'name' => 'shop_image',
                'note' => 'Allow image type: jpg, jpeg, gif, png',
                'required'     => true,
            ]
        );
          
        
          
    $wysiwygConfig = $this->_wysiwygConfig->getConfig();
    
        $fieldset->addField(
            'shop_description',
            'editor',
            [
                'name'        => 'shop_description',
                'label'    => __('Shop Description'),
                'required'     => true,
                'config'    => $wysiwygConfig
            ]
        );
        
        $fieldset->addField(
            'shop_timings',
            'editor',
            [
                'name'        => 'shop timings',
                'label'    => __('Shop Open Time Information'),
                'required'     => true,
                'config'    => $wysiwygConfig
            ]
        );
    
    $fieldset->addField(
       'store_id',
       'multiselect',
       [
         'name'     => 'store_id[]',
         'label'    => __('Store Views'),
         'title'    => __('Store Views'),
         'required' => true,
         'values'   => $this->_systemStore->getStoreValuesForForm(false, true),
       ]
    );    
        
//    $fieldset->addField(
//       'shop_view',
//       'multiselect',
//       [
//         'name'     => 'shop_view[]',
//         'label'    => __('Store Views'),
//         'title'    => __('Store Views'),
//         'required' => true,
//         'values'   => $this->_systemStore->getStoreValuesForForm(false, true),
//       ]
//    );  
        
        if (!$model->getId()) {
            //$model->setData('is_active', $isElementDisabled ? '0' : '1');
        }
        $form->setValues($model->getData());
        $this->setForm($form);
        return parent::_prepareForm();
    }

    /**
     * Prepare label for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabLabel() {
        return __('Shop Information');
    }

    /**
     * Prepare title for tab
     *
     * @return \Magento\Framework\Phrase
     */
    public function getTabTitle() {
        return __('Shop Information');
    }

    /**
     * {@inheritdoc}
     */
    public function canShowTab() {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isHidden() {
        return false;
    }

    /**
     * Check permission for passed action
     *
     * @param string $resourceId
     * @return bool
     */
    protected function _isAllowedAction($resourceId) {
        return $this->_authorization->isAllowed($resourceId);
    }

}
