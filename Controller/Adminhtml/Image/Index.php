<?php 

namespace AHT\Portfolio\Controller\Adminhtml\Image;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Index extends \Magento\Backend\App\Action
{
    protected $resultPageFactory;
    protected $request;
    protected $_registry;

    public function __construct(
        Context $context,
        \Magento\Framework\App\Request\Http $request,
        \Magento\Framework\Registry $registry,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->request = $request;
        $this->_registry = $registry;
        $this->resultPageFactory = $resultPageFactory;
    }

    public function execute()
    {
        //GetId vao trong model
        $getId = $this->request->getParam('id');
        $this->_registry->register('id_var', $getId);
        $id = $this->_registry->registry('id_var');

        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('AHT_Images:index');
        $resultPage->addBreadcrumb(__('Portfolio'), __('Portfolio'));
        $resultPage->addBreadcrumb(__('Manage Portfolio'), __('Manage Portfolio'));
        $resultPage->getConfig()->getTitle()->prepend(__('Portfolio'));
        return $resultPage;
    } 
} 