<?php

namespace Crimson\ProductRange\Block;

use Magento\Catalog\Ui\DataProvider\Product\ProductCollectionFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Data\Collection;
use Magento\Framework\View\Element\AbstractBlock;
use Magento\Framework\View\Element\Template;

class ProductData extends AbstractBlock
{
    private $collectionFactory;

    private $request;

    /**
     * ProductData constructor.
     * @param Template\Context $context
     * @param RequestInterface $request
     * @param ProductCollectionFactory $productCollectionFactory
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        RequestInterface $request,
        ProductCollectionFactory $productCollectionFactory,
        array $data = []
    ) {
        $this->request = $request;
        $this->collectionFactory = $productCollectionFactory;
        parent::__construct($context, $data);
    }

    public function getCollection(): Collection
    {
        $params = $this->getParams();
        print_r($params);die();
        return $this->collectionFactory->create()
            ->addAttributeToSelect('*')
            ->addFieldToFilter( 'price' , array('from' => $params['low'], 'to' => $params['high']) )
            ->setOrder('price', $params['sort'] )
        ->setPageSize(10);
    }

    private function getParams(): array
    {
        return $this->request->getParams();
    }

    public function toHtml()
    {
        print_r($this->getData('template'));die();
        $this->getCollection();
    }

}