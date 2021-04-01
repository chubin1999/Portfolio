<?php
namespace AHT\Portfolio\Model\ResourceModel;

class Portfolio extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb {
	protected function _construct() 
	{
		$this->_init('AHT_Portfolio', 'id');
	}
    /**
     * Retrieve select object for load object data
     * 
     * @param string $mainTable
     * @param string $field
     * @param mixed $value
     * @param \Magento\Framework\Model\AbstractModel $object
     * @return \Magento\Framework\DB\Select
     */
    protected function _getLoadSelect($field, $value, $object)
    {
    	$field = $this->getConnection()->quoteIdentifier(sprintf('%s.%s', $this->getMainTable(), $field));
    	$select = $this->getConnection()
    	->select()
    	->from($this->getMainTable())
    	->where($field . '=?', $value)
    	->joinRight('AHT_Images',
    		'AHT_Portfolio.id = AHT_Images.PortfolioId',
    		[
    			'AHT_Images.path'
    		])
    	->joinLeft('AHT_Categories',
    		'AHT_Portfolio.categoryid = AHT_Categories.id',
    		[
    			'AHT_Categories.name'
    		]);
    	return $select;
    }

}