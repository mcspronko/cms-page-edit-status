<?php
/**
 * Copyright © Pronko Consulting (https://www.pronkoconsulting.com)
 * See LICENSE for the license details.
 */
declare(strict_types=1);

namespace Pronko\CmsPageEditStatus\Service;

use Magento\User\Api\Data\UserInterface;
use Magento\User\Model\ResourceModel\User\Collection;
use Magento\User\Model\ResourceModel\User\CollectionFactory;

/**
 * Class UserProvider
 */
class UserProvider
{
    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * UserProvider constructor.
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(CollectionFactory $collectionFactory)
    {
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * @param int $userId
     * @return UserInterface
     */
    public function getUser(int $userId): UserInterface
    {
        /** @var Collection $collection */
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter('main_table.user_id', $userId);

        /** @var UserInterface $user */
        $user = $collection->getFirstItem();

        return $user;
    }
}
