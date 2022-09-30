<?php

namespace Crimson\ProductRange\Block;

use Magento\Catalog\Ui\DataProvider\Product\ProductCollectionFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Data\Collection;
use Magento\Framework\View\Element\Template;
use Magento\Catalog\Helper\Product as ProductImageHelper;
use Magento\InventoryApi\Api\GetSourceItemsBySkuInterface;

class ProductData extends Template
{
    private $collectionFactory;

    private $request;

    private $productImageHelper;

    private $getSourceItemsBySku;

    /**
     * ProductData constructor.
     * @param Template\Context $context
     * @param RequestInterface $request
     * @param ProductCollectionFactory $productCollectionFactory
     * @param ProductImageHelper $productImageHelper
     * @param GetSourceItemsBySkuInterface $getSourceItemsBySku
     * @param array $data
     */
    public function __construct(
        Template\Context $context,
        RequestInterface $request,
        ProductCollectionFactory $productCollectionFactory,
        ProductImageHelper $productImageHelper,
        GetSourceItemsBySkuInterface $getSourceItemsBySku,
        array $data = []
    ) {
        $this->request = $request;
        $this->collectionFactory = $productCollectionFactory;
        $this->productImageHelper = $productImageHelper;
        $this->getSourceItemsBySku = $getSourceItemsBySku;
        parent::__construct($context, $data);
    }

    public function getCollection(): Collection
    {
        $params = $this->getParams();

        return $this->collectionFactory->create()
            ->addAttributeToSelect('price')
            ->addAttributeToSelect('sku')
            ->addAttributeToSelect('thumbnail')
            ->addAttributeToSelect('name')
            ->addAttributeToSelect('qty')
            ->addAttributeToSelect('url')
            ->addFieldToFilter( 'price' , ['from' => $params['low'], 'to' => $params['high']] )
            ->setOrder('price', $params['sort'] )
        ->setPageSize(10);
    }

    private function getParams(): array
    {
        return $this->request->getParams();
    }

    public function toHtml(): string
    {
        if ($this->getCollection()->count() == 0) {
            return "No items returned";
        }
        $result = '<table>
            <tr>
                <td>Thumbnail</td>
                <td>SKU</td>
                <td>Name</td>
                <td>QTY</td>
                <td>Price</td>
                <td>Link</td>
            </tr>
        ';
        foreach ($this->getCollection()->getItems() as $item) {
            $sourceItem = $this->getSourceItemsBySku->execute($item->getSku());
            $result .= "<tr>
                <td><img width='100' src='{$this->productImageHelper->getThumbnailUrl($item)}'/></td>
                <td>{$item->getSku()}</td>
                <td>{$item->getName()}</td>
                <td>{$sourceItem->getQuantity()}</td>
                <td>{$item->getPrice()}</td>
                <td><a href='{$item->getUrlModel()->getUrl($item)}' target='_blank'>Page</a></td>
            </tr>";

        }
        $result .= '</table>';
        return $result;
    }

}