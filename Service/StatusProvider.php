<?php
/**
 * Copyright © Pronko Consulting (https://www.pronkoconsulting.com)
 * See LICENSE for the license details.
 */
declare(strict_types=1);

namespace Pronko\CmsPageEditStatus\Service;

use Magento\Framework\Exception\NoSuchEntityException;
use Pronko\CmsPageEditStatus\Model\ResourceModel\Status\Collection;
use Pronko\CmsPageEditStatus\Model\ResourceModel\Status\CollectionFactory;
use Pronko\CmsPageEditStatus\Model\Status;

/**
 * Class StatusProvider
 */
class StatusProvider
{
    /**
     * @var Status[]
     */
    private $statuses;

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    public function __construct(CollectionFactory $collectionFactory)
    {
        $this->collectionFactory = $collectionFactory;
        $this->statuses = [];
    }

    /**
     * @param int $pageId
     * @return Status|null
     */
    private function getStatusByPageId(int $pageId): ?Status
    {
        if (!isset($this->statuses[$pageId])) {
            $collection = $this->collectionFactory->create();
            $collection->addFieldToFilter('page_id', $pageId);
            $collection->addFieldToFilter('status', 'edit');

            /** @var Status $status */
            $status = $collection->getFirstItem();
            if ($status->getId()) {
                $this->statuses[$pageId] = $status;
            }
        }

        if (!isset($this->statuses[$pageId])) {
            return null;
        }

        return $this->statuses[$pageId];
    }

    /**
     * @param int $pageId
     * @return Status
     * @throws NoSuchEntityException
     */
    public function getByPageId(int $pageId): Status
    {
        $status = $this->getStatusByPageId($pageId);

        if (!$status) {
            throw new NoSuchEntityException(__('There is no status information for for the page with ID: ' . $pageId));
        }
        return $status;
    }

    /**
     * @param int $pageId
     * @return bool
     */
    public function hasStatus(int $pageId): bool
    {
        return (bool) $this->getStatusByPageId($pageId);
    }
}
