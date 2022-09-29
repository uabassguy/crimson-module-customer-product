<?php

namespace Crimson\ProductRange\Block;

use Magento\Catalog\Ui\DataProvider\Product\ProductCollectionFactory;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Data\Collection;
use Magento\Framework\View\Element\Template;

class ProductData extends Template
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

    public function toHtml()
    {
        if ($this->getCollection()->count() == 0) {
            return "No items returned";
        }
        echo '<table>
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
            ?>
            <tr>
                <td><img src="<?= $item->getThumbnail() ?>"/></td>
                <td><?= $item->getSku() ?></td>
                <td><?= $item->getName() ?></td>
                <td><?= $item->getQty() ?></td>
                <td><?= $item->getPrice() ?></td>
                <td><a href="<?= $item->getUrl() ?>" target="_blank">Page</a></td>
            </tr>
            <?php
        }
        echo '</table>';
    }

}