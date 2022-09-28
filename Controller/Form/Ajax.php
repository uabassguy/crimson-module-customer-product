<?php

namespace Crimson\ProductRange\Controller\Form;

use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface as HttpGetActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Controller\ResultInterface;

class Ajax extends \Magento\Framework\App\Action\Action implements HttpGetActionInterface
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * Index constructor.
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    public function execute(): ResultInterface
    {
        /** @var \Magento\Framework\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();

        $params = $this->getRequest()->getParams();
        $valid = $this->validate($params);

        $resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        if (!$valid) {
            $resultJson->setData([
                "suceess" => false
            ]);
        } else {
            $resultJson->setData([
                "suceess" => true,
                "html" => $this->getBlockHtml($resultPage)
            ]);
        }

        return $resultJson;
    }

    private function validate(array $params): bool
    {
        if (!isset($params['low']) || !isset($params['high']) || !isset($params['sort'])) {
            return false;
        }
        if (!is_numeric($params['low']) || !is_numeric($params['high'])) {
            return false;
        }
        if ($params['sort'] != 'asc' && $params['sort'] != 'desc') {
            return false;
        }
        return true;
    }

    private function getBlockHtml(\Magento\Framework\View\Result\Page $resultPage)
    {
        $block = $resultPage->getLayout()->createBlock(
            'Crimson\ProductRange\Block\ProductData',
            'product_table',
            [
                'template' => 'Crimson_ProductRange::product_table.phtml'
            ]
        );
        $block->setTemplate('Crimson_ProductRange::product_table.phtml');
        return $block->toHtml();
    }
}