<?php

namespace Crimson\ProductRange\Controller\Form;

use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface as HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\View\Result\PageFactory;
use Magento\Framework\Controller\ResultInterface;

class Ajax extends \Magento\Framework\App\Action\Action implements HttpPostActionInterface
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
                "suceess" => false,
                "html" => "No results returned"
            ]);
        } else {
            $resultJson->setData([
                "suceess" => true,
                "html" => $resultPage->getLayout()->getBlock('product_table')->toHtml()
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
        if ($params['high'] < $params['low'] || $params['high'] > ($params['low'] * 5)) {
            return false;
        }
        return true;
    }
}