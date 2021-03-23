<?php

namespace AHT\Portfolio\Controller\Adminhtml\Category;

class Delete extends \Magento\Backend\App\Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */


    /**
     * Delete Banner
     *
     * @return \Magento\Framework\View\Result\PageFactory
     */
    public function execute()
    {
        // check if we know what should be deleted
        $bannerId = (int)$this->getRequest()->getParam('id');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($bannerId && (int) $bannerId > 0) {
            try {
                $model = $this->_objectManager->create('AHT\Portfolio\Model\Category');
                $model->load($bannerId);
                $model->delete();
                $this->messageManager->addSuccess(__('The Category has been deleted successfully.'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addError($e->getMessage());
                // go back to the question grid
                return $resultRedirect->setPath('*/*/category');
            }
        }
        // display error message
        $this->messageManager->addError(__('Portfolio doesn\'t exist any longer.'));
        // go to the question grid
        return $resultRedirect->setPath('*/*/category');
    }
}