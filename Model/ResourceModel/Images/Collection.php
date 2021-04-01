<?php
namespace AHT\Portfolio\Model\ResourceModel\Images;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
	/**
	 * Define resource model
	 *
	 * @return void
	 */
	protected function _construct()
	{
		$this->_init('AHT\Portfolio\Model\Images', 'AHT\Portfolio\Model\ResourceModel\Images');
	}
} 