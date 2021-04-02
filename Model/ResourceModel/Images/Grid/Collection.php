<?php
namespace AHT\Portfolio\Model\ResourceModel\Images\Grid;

use AHT\Portfolio\Model\Images;
use Magento\Framework\Api;
use Magento\Framework\Event\ManagerInterface as EventManager;
use Magento\Framework\Data\Collection\Db\FetchStrategyInterface as FetchStrategy;
use Magento\Framework\Data\Collection\EntityFactoryInterface as EntityFactory;
use Psr\Log\LoggerInterface as Logger;

// use Magento\Framework\Api\Search\SearchResultInterface;

class Collection extends \Magento\Framework\View\Element\UiComponent\DataProvider\SearchResult
{
   /**
     * Value of seconds in one minute
     */
   const SECONDS_IN_MINUTE = 60;

    /**
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    protected $date;

    /**
     * @var Visitor
     */
    protected $visitorModel;
    protected $_request;
    protected $resultPageFactory;
    protected $_registry;

    /**
     * @param EntityFactory $entityFactory
     * @param Logger $logger
     * @param FetchStrategy $fetchStrategy
     * @param EventManager $eventManager
     * @param string $mainTable
     * @param string $resourceModel
     * @param Visitor $visitorModel
     * @param \Magento\Framework\Stdlib\DateTime\DateTime $date
     */
    public function __construct(
        EntityFactory $entityFactory,
        Logger $logger,
        FetchStrategy $fetchStrategy,
        EventManager $eventManager,
        $mainTable,
        $resourceModel,
        Images $imagesModel,
        \Magento\Framework\Stdlib\DateTime\DateTime $date,
        \Magento\Framework\App\Request\Http $request,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        $this->date = $date;
        $this->_registry = $registry;
        $this->imagesModel = $imagesModel;
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $mainTable, $resourceModel, $request);
        $this->_request = $request;
        $this->resultPageFactory = $resultPageFactory;
    }

    protected function _initSelect()
    {
        $idimg = (int)$this->_registry->registry('id_var'); 

        $this->getSelect()
        ->from('AHT_Images')
        ->where('portfolio_id' .' = '. $idimg)
        ->join('AHT_Portfolio',
            'AHT_Images.portfolio_id = AHT_Portfolio.id',
            [
                'AHT_Portfolio.*'
            ]);


        $this->addFilterToMap('image_id', 'AHT_Images.image_id');
        return $this;
    }
}
