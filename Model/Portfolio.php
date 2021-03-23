<?php
namespace AHT\Portfolio\Model;

use AHT\Portfolio\Api\Data\PortfolioInterface;

class Portfolio extends \Magento\Framework\Model\AbstractModel implements PortfolioInterface {
    const CACHE_TAG = 'aht_portfolio_post';
    public function __construct(
   	 \Magento\Framework\Model\Context $context,
   	 \Magento\Framework\Registry $registry,
   	 \Magento\Framework\Model\ResourceModel\AbstractResource $resource =
   	 null,
   	 \Magento\Framework\Data\Collection\AbstractDb $resourceCollection =
   	 null,
   	 array $data = []
    ) {
   	 parent::__construct($context, $registry, $resource,$resourceCollection, $data);
    }
    public function _construct() {
		$this->_init('AHT\Portfolio\Model\ResourceModel\Portfolio');
    }

    
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }
    public function getDefaultValues()
    {
        $values = [];
    return $values;
    }

    public function getId()
    {
        return $this->getData('id');
    }
    public function setId($id)
    {
        $this->getData('id', $id);
    } 

    public function getTitle()
    {
        return $this->getData('title');
    }
    public function setTitle($title)
    {
        $this->getData('title', $title);
    } 

    public function getImages()
    {
        return $this->getData('images');
    }
    public function setImages($images)
    {
        $this->getData('images', $images);
    } 

    public function getCategoryid()
    {
        return $this->getData('categoryid');
    }
    public function setCategoryid($categoryid)
    {
        $this->getData('categoryid', $categoryid);
    }

    public function getDescription()
    {
        return $this->getData('description');
    }
    public function setDescription($description)
    {
        $this->getData('description', $description);
    } 

    public function getPrice()
    {
        return $this->getData('price');
    }
    public function setPrice($price)
    {
        $this->getData('price', $price);
    } 

    public function getContent()
    {
        return $this->getData('content');
    }
    public function setContent($content)
    {
        $this->getData('content', $content);
    } 
    
}