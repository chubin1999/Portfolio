<?php
namespace AHT\Portfolio\Model;

use \Magento\Framework\DataObject\IdentityInterface;

// class Portfolio extends AbstractModel implements IdentityInterface
class Images extends \Magento\Framework\Model\AbstractModel {
    
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
		$this->_init('AHT\Portfolio\Model\ResourceModel\Images');
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

    public function getImageId()
    {
        return $this->getData('image_id');
    }
    public function setImageId($id)
    {
        $this->setData('image_id', $id);
    }

    public function getPortfolioId()
    {
        return $this->getData('PortfolioId');
    }
    public function setPortfolioId($id)
    {
        $this->setData('PortfolioId', $id);
    }
     
    public function getPath()
    {
        return $this->getData('path');
    }
    public function setPath($path)
    {
        $this->setData('path', $path);
    } 
}