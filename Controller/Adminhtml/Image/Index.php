<?php 

namespace AHT\Portfolio\Controller\Adminhtml\Image;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use AHT\Portfolio\Model\ResourceModel\Images\Grid\CollectionFactory;

class Index extends \Magento\Backend\App\Action
{
    protected $resultPageFactory;
    protected $request;
    protected $_registry;
    protected $imgCollection;

    public function __construct(
        Context $context,
        \Magento\Framework\App\Request\Http $request,
        \Magento\Framework\Registry $registry,
        PageFactory $resultPageFactory,
        CollectionFactory $imgCollection
    ) {
        parent::__construct($context);
        $this->request = $request;
        $this->_registry = $registry;
        $this->resultPageFactory = $resultPageFactory;
        $this->imgCollection = $imgCollection;

    }

    public function execute()
    {
        $imgCollection2 = $this->imgCollection->create();
        //GetId vao trong model
        $getId = $this->request->getParam('id');
        /*$getId;*/
        /*$this->_registry->register('id_var', $getId);
        $id = $this->_registry->registry('id_var');*/
        $imgCollection2->setPortfolioId($getId);

        $imgCollection2->getPortfolioId();

        die('abc');

        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('AHT_Images:index');
        $resultPage->addBreadcrumb(__('Portfolio'), __('Portfolio'));
        $resultPage->addBreadcrumb(__('Manage Portfolio'), __('Manage Portfolio'));
        $resultPage->getConfig()->getTitle()->prepend(__('Portfolio'));
        return $resultPage;
    } 
} 