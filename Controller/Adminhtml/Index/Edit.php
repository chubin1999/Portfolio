<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace AHT\Portfolio\Controller\Adminhtml\Index;

use Magento\Framework\App\Action\HttpGetActionInterface;

/**
 * Edit CMS block action.
 */
class Edit extends \AHT\Portfolio\Controller\Adminhtml\Portfolio implements HttpGetActionInterface
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;
    protected $_postFactory;
    protected $_imagesFactory;
    protected $_portfolioResourceFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \AHT\Portfolio\Model\PortfolioFactory $postFactory,
        \AHT\Portfolio\Model\ImagesFactory $imagesFactory,
        \AHT\Portfolio\Model\ResourceModel\PortfolioFactory $portfolioResourceFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context, $coreRegistry);
        $this->_postFactory = $postFactory;
        $this->_imagesFactory = $imagesFactory;
        $this->_portfolioResourceFactory = $portfolioResourceFactory;
    }

    /**
     * Edit CMS block
     *
     * @return \Magento\Framework\Controller\ResultInterface
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {

        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('id');
        $model = $this->_postFactory->create();
        $modelresource = $this->_portfolioResourceFactory->create();
        $image = $this->_imagesFactory->create();

        // 2. Initial checking
        if ($id) {
            $modelresource->load($model, $id);
            /*echo "<pre>";
            var_dump($model->getData());
            die();*/
            /*$image->load($model['id']);*/
            /*echo "<pre>";
            var_dump($image->getData());*/
            /*die();*/
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This block no longer exists.'));
                /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }

        //register: luu bien
        $this->_coreRegistry->register('portfolio', $model);

        // 5. Build edit form
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();

        $this->initPage($resultPage)->addBreadcrumb(
            $id ? __('Edit Block') : __('New Block'),
            $id ? __('Edit Block') : __('New Block')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('All Portfolio'));
        $resultPage->getConfig()->getTitle()->prepend($model->getId() ? $model->getTitle() : __('New Portfolio'));
        return $resultPage;
    }
}
