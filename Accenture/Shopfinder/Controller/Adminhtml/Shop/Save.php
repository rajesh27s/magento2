<?php

namespace Accenture\Shopfinder\Controller\Adminhtml\Shop;

use Magento\Backend\App\Action;
use Magento\Framework\App\Filesystem\DirectoryList;


class Save extends \Magento\Backend\App\Action {

    protected $datetime;
    protected $_fileUploaderFactory;

    public function __construct(
    \Magento\MediaStorage\Model\File\UploaderFactory $fileUploaderFactory, Action\Context $context
    ) {

        $this->_fileUploaderFactory = $fileUploaderFactory;
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute() {
        $store = array();
        $data = $this->getRequest()->getPostValue();
        print_r($data);
        $localeDate = $this->_objectManager->get('Magento\Framework\Stdlib\DateTime');
        $date = $localeDate->formatDate(true);

        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            $model = $this->_objectManager->create('Accenture\Shopfinder\Model\Shop');
            $id = $this->getRequest()->getParam('shop_id');

            if (!isset($id)) {
                $data['shop_created_at'] = $date;
                $data['shop_modified_at'] = $date;
            }

            if ($id) {
                $model->load($id);
                $data['shop_modified_at'] = $date;
            }
            $store = $this->getRequest()->getParam('store_id');
            $shopStoreId = implode(",",$store);
            if(count($store) > 1)
                $data['store_id'] = $store[0];
            else
                $data['store_id'] = $shopStoreId;
                   
            
            $data['shop_view'] = $shopStoreId;
            
            
            $model->setData($data);
            try {
                
                $imageRequest = $this->getRequest()->getFiles('shop_image');
                //print_r($imageRequest);

                if ($imageRequest) {
                    if (isset($imageRequest['name'])) {
                        $fileName = $imageRequest['name'];
                    } else {
                        $fileName = '';
                    }
                } else {
                    $fileName = '';
                }

                if ($imageRequest && strlen($fileName)) {
                    /*
                     * Save image upload
                     */
                    try {
                         
                        $uploader = $this->_fileUploaderFactory->create(['fileId' =>'shop_image']);
                        $uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);
                        $uploader->setAllowRenameFiles(true);
                        $uploader->setFilesDispersion(true);
                        
                        $path = $this->_objectManager->get('Magento\Framework\Filesystem')->getDirectoryRead(DirectoryList::MEDIA)->getAbsolutePath(\Accenture\Shopfinder\Model\Shop::BASE_MEDIA_PATH);
                        $result = $uploader->save($path);
                        
                        ///$data['shop_image']=\Accenture\Shopfinder\Model\Shop::BASE_MEDIA_PATH.$result['file'];
                     //$data['shop_image'] = addslashes($result['file']);
                     //$data['shop_image_path']=$result['file'];
                     $shopImg = $result['file'];
                     
                    //$model->setData($data)->setShopImage($shopImg);
                    $model->setData($data)->setShopImagePath($shopImg);
                    
                    } catch (\Exception $e) {
                        if ($e->getCode() == 0) {
                            $this->messageManager->addError($e->getMessage());
                        }
                    }
                } else {

                    
                    if (isset($data['shop_image']) && isset($data['shop_image']['value'])) {
                        if (isset($data['shop_image']['delete'])) {
                            $data['shop_image'] = null;
                            $data['delete_image'] = true;
                        } elseif (isset($data['shop_image']['value'])) {
                            $data['shop_image'] = $data['shop_image']['value'];
                        } else {
                            $data['shop_image'] = null;
                        }
                    }
                }

                $model->save();
                $this->messageManager->addSuccess(__('The shop has been saved.'));
                $this->_objectManager->get('Magento\Backend\Model\Session')->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the shop.'));
            }
            $this->_getSession()->setFormData($data);
            return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('shop_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }

}
