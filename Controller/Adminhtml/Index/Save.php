<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace AHT\Portfolio\Controller\Adminhtml\Index;

use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Registry;
use AHT\Portfolio\Api\PortfolioRepositoryInterface;
use AHT\Portfolio\Model\Portfolio;
use AHT\Portfolio\Model\PortfolioFactory;
use AHT\Portfolio\Model\Images;
use AHT\Portfolio\Model\ImagesFactory;
use AHT\Portfolio\Model\Portfolio\ImageUploader;

/**
 * Save CMS block action.
 */
class Save extends \AHT\Portfolio\Controller\Adminhtml\Portfolio implements HttpPostActionInterface
{
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var BlockFactory
     */
    private $blockFactory;

    /**
     * @var BlockRepositoryInterface
     */
    private $blockRepository;

     /**
     * @var ImageFactory
     */
     private $imagesFactory;

    /**
     * @var ImageUploader
     */
    protected $imageUploader;
    /**
     * @param Context $context
     * @param Registry $coreRegistry
     * @param DataPersistorInterface $dataPersistor
     * @param BlockFactory|null $blockFactory
     * @param BlockRepositoryInterface|null $blockRepository
     * @param ImageUploader $imageUploader
     */
    public function __construct(
        Context $context,
        Registry $coreRegistry,
        DataPersistorInterface $dataPersistor,
        PortfolioFactory $blockFactory = null,
        ImagesFactory $imagesFactory = null,
        ImageUploader $imageUploader,
        PortfolioRepositoryInterface $blockRepository = null
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->blockFactory = $blockFactory
        ?: \Magento\Framework\App\ObjectManager::getInstance()->get(PortfolioFactory::class);
        $this->imagesFactory = $imagesFactory
        ?: \Magento\Framework\App\ObjectManager::getInstance()->get(ImagesFactory::class);
        $this->blockRepository = $blockRepository
        ?: \Magento\Framework\App\ObjectManager::getInstance()->get(PortfolioRepositoryInterface::class);
        $this->imageUploader = $imageUploader;
        parent::__construct($context, $coreRegistry);  
    }

    /**
     * Save action
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();

        $data = $this->getRequest()->getPostValue();
        if ($data) {
            /*if (isset($data['is_active']) && $data['is_active'] === 'true') {
                $data['is_active'] = Block::STATUS_ENABLED;
            }*/
            if (empty($data['id'])) {
                $data['id'] = null;
            }
            /** @var \Magento\Cms\Model\Block $model */
            $model = $this->blockFactory->create();
            $image = $this->imagesFactory->create();

            $id = $this->getRequest()->getParam('id');
            if ($id) {
                try {
                    $model = $this->blockRepository->getById($id);
                } catch (LocalizedException $e) {
                    $this->messageManager->addErrorMessage(__('This block no longer exists.'));
                    return $resultRedirect->setPath('*/*/');
                }
            }

            $model->setData($data);

            try {
                /*Đầu tiên lưu đối tượng vào bảng AHT_Portfilio*/
                $this->blockRepository->save($model);

                /*Đây là lấy id của Porftolio khởi tạo ở trên*/
                $portfolioId = $model->getId();

                /*Dùng foreach để duyệt mảng để lưu ảnh của Portfolio vào bảng AHT_Images*/
                foreach ($model['image'] as $key => $value) {
                   /* Mỗi lần for sẽ khởi tạo 1 đối tượng Image mới */
                   $image = $this->imagesFactory->create();

                   /* Set dữ liệu cho đối tượng image*/
                   $image->setPath($value['name']);
                   $image->setPortfolioId($portfolioId);

                   /*Lưu đối tượng vào bảng AHT_Images*/
                   $image->save();

                   /*Move ảnh vào pub*/
                   $this->imageUploader->moveFileFromTmp($value['name']);
               }

                $this->messageManager->addSuccessMessage(__('You saved the block.'));
                $this->dataPersistor->clear('fortfolio');
                
                return $this->processBlockReturn($model, $data, $resultRedirect);
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the block.'));
            }

            $this->dataPersistor->set('fortfolio', $data);
            return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
        }
        return $resultRedirect->setPath('*/*/');
    }

    /**
     * Process and set the block return
     *
     * @param \Magento\Cms\Model\Block $model
     * @param array $data
     * @param \Magento\Framework\Controller\ResultInterface $resultRedirect
     * @return \Magento\Framework\Controller\ResultInterface
     */
    private function processBlockReturn($model, $data, $resultRedirect)
    {
        $redirect = $data['back'] ?? 'close';

        if ($redirect ==='continue') {
            $resultRedirect->setPath('*/*/edit', ['id' => $model->getId()]);
        } else if ($redirect === 'close') {
            $resultRedirect->setPath('*/*/');
        } else if ($redirect === 'duplicate') {
            $duplicateModel = $this->blockFactory->create(['data' => $data]);
            $duplicateModel->setId(null);
            $duplicateModel->setIdentifier($data['identifier'] . '-' . uniqid());
            $duplicateModel->setIsActive(Block::STATUS_DISABLED);
            $this->blockRepository->save($duplicateModel);
            $id = $duplicateModel->getId();
            $this->messageManager->addSuccessMessage(__('You duplicated the block.'));
            $this->dataPersistor->set('portfolio', $data);
            $resultRedirect->setPath('*/*/edit', ['id' => $id]);
        }
        return $resultRedirect;
    }
}
