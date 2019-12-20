<?php
/**
 * Copyright © Pronko Consulting (https://www.pronkoconsulting.com)
 * See LICENSE for the license details.
 */
declare(strict_types=1);

namespace Pronko\CmsPageEditStatus\Service;

use Magento\Backend\Model\Auth;
use Magento\Backend\Model\Auth\Credential\StorageInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\User\Model\User;
use Pronko\CmsPageEditStatus\Model\ResourceModel\Status\Collection;
use Pronko\CmsPageEditStatus\Model\ResourceModel\Status\CollectionFactory;
use Pronko\CmsPageEditStatus\Model\Status;
use Psr\Log\LoggerInterface;

/**
 * Class PageStatusUpdater
 */
class PageStatusUpdater
{
    /**
     * @var Auth
     */
    private $auth;

    /**
     * @var CurrentPage
     */
    private $currentPage;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * PageStatusUpdater constructor.
     * @param Auth $auth
     * @param CurrentPage $currentPage
     * @param CollectionFactory $collectionFactory
     * @param LoggerInterface $logger
     */
    public function __construct(
        Auth $auth,
        CurrentPage $currentPage,
        CollectionFactory $collectionFactory,
        LoggerInterface $logger
    ) {
        $this->auth = $auth;
        $this->currentPage = $currentPage;
        $this->logger = $logger;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * @throws LocalizedException
     */
    public function execute()
    {
        try {
            $page = $this->currentPage->get();
        } catch (NoSuchEntityException $exception) {
            return;
        }

        /** @var StorageInterface|User $user */
        $user = $this->auth->getUser();

        $userId = (int) $user->getId();
        $pageId = (int) $page->getId();

        $status = $this->getStatus($userId, $pageId);
        if ($status->getId()) {
            $data = [
                'current_timestamp' => time(),
                'updated_at' => time(),
            ];
        } else {
            $data = [
                'user_id' => $userId,
                'page_id' => $pageId,
                'status' => 'edit',
                'current_timestamp' => time(),
            ];
        }

        $status->addData($data);

        /** @var Collection $collection */
        $collection = $this->collectionFactory->create();
        $collection->getResource()->save($status);
    }

    /**
     * @param int $userId
     * @param int $pageId
     * @return Status
     */
    private function getStatus($userId, $pageId)
    {
        /** @var Collection $collection */
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter('user_id', $userId);
        $collection->addFieldToFilter('page_id', $pageId);

        /** @var Status $status */
        $status = $collection->getFirstItem();

        return $status;
    }
}
