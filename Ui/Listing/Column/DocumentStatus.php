<?php
/**
 * Copyright © Pronko Consulting (https://www.pronkoconsulting.com)
 * See LICENSE for the license details.
 */
declare(strict_types=1);

namespace Pronko\CmsPageEditStatus\Ui\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Pronko\CmsPageEditStatus\Ui\Listing\Column\DocumentStatus\Value;

/**
 * Class DocumentStatus
 */
class DocumentStatus extends Column
{
    /**
     * @var Value
     */
    private $value;

    /**
     * DocumentStatus constructor.
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param Value $value
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        Value $value,
        array $components = [],
        array $data = []
    ) {
        $this->value = $value;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                $item[$this->getData('name')] = $this->prepareItem($item);
            }
        }

        return $dataSource;
    }

    /**
     * @param array $item
     * @return string
     */
    private function prepareItem(array $item): string
    {
        return $this->value->get((int)$item['page_id']);
    }
}
