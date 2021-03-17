<?php
namespace AHT\Portfolio\Block\Frontend\Portfolio;

use Magento\Framework\View\Element\Template;
use Magento\Widget\Block\BlockInterface;
use Magento\Framework\View\Element\Template\Context;
use AHT\Portfolio\Model\ResourceModel\Portfolio\CollectionFactory;

class Index extends Template implements BlockInterface
{
    protected $_collection;
    public $_storeManager;
    public $_customerSession;

    public function __construct(
        CollectionFactory $portfolioCollectionFactory,
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Customer\Model\Session $customerSession,  
        array $data = []

    )
    {
        parent::__construct($context, $data);
        $this->_customerSession = $customerSession;
        $this->_collection =  $portfolioCollectionFactory->create();
    }

    public function getDataBlocks()
    {

        $portfolio = $this->_collection;
        $items = $portfolio->getItems();
        foreach($items as $item)
        { 
            $itemData = $item->getData();
            $this->_loadedData[$item->getId()] = $itemData;
        }

        return $this->_loadedData;
    }

    public function getStoreManager(){
        return $this->_storeManager;
    }
}