<?php

namespace Crimson\ProductRange\Controller\Customer\Account\ProductRange;

use Magento\Framework\Controller\ResultFactory;

class IndexController extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Magento\Framework\App\Action\Context
     */
    private $context;
    /**
     * @param \Magento\Framework\App\Action\Context $context
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context
    ) {
        parent::__construct($context);
        $this->context           = $context;
    }

    /**
     * @return Json
     */
    public function execute()
    {
        $params = $this->context->getRequest()->getParams();

        $this->validate($params);

        $resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $resultJson->setData(["message" => ("Test"), "suceess" => true]);
        return $resultJson;
    }

    private function validate(array $params)
    {

    }
}