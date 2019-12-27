<?php
/**
 * Copyright © Pronko Consulting (https://www.pronkoconsulting.com)
 * See LICENSE for the license details.
 */
declare(strict_types=1);

namespace Pronko\CmsPageEditStatus\Service;

use Magento\Framework\Exception\NoSuchEntityException;
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
     * @var UserInterface[]
     */
    private $users;

    /**
     * UserProvider constructor.
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(CollectionFactory $collectionFactory)
    {
        $this->collectionFactory = $collectionFactory;
        $this->users = [];
    }

    /**
     * @param int $userId
     * @return UserInterface
     * @throws NoSuchEntityException
     */
    public function getById(int $userId): UserInterface
    {
        if (!array_key_exists($userId, $this->users)) {
            /** @var Collection $collection */
            $collection = $this->collectionFactory->create();
            $collection->addFieldToFilter('main_table.user_id', $userId);

            /** @var UserInterface $user */
            $user = $collection->getFirstItem();

            if (!$user->getId()) {
                throw new NoSuchEntityException(__('There is no user with ID: %1', $userId));
            }
            $this->users[$userId] = $user;
        }

        return $this->users[$userId];
    }
}
