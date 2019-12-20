<?php
/**
 * Copyright © Pronko Consulting (https://www.pronkoconsulting.com)
 * See LICENSE for the license details.
 */
declare(strict_types=1);

namespace Pronko\CmsPageEditStatus\Ui\Listing\Column;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Pronko\CmsPageEditStatus\Model\Status;
use Pronko\CmsPageEditStatus\Service\StatusProvider;
use Pronko\CmsPageEditStatus\Service\UserProvider;

/**
 * Class EditStatus
 */
class EditStatus extends Column
{
    /**
     * @var StatusProvider
     */
    private $statusProvider;

    /**
     * @var UserProvider
     */
    private $userProvider;

    /**
     * EditStatus constructor.
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param StatusProvider $statusProvider
     * @param UserProvider $userProvider
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        StatusProvider $statusProvider,
        UserProvider $userProvider,
        array $components = [],
        array $data = []
    ) {
        $this->statusProvider = $statusProvider;
        $this->userProvider = $userProvider;
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
     * @throws NoSuchEntityException
     */
    private function prepareItem(array $item)
    {
        $pageId = (int) $item['page_id'];

        if ($this->statusProvider->hasStatus($pageId)) {
            try {
                $status = $this->statusProvider->getByPageId($pageId);
                return $this->addStatusData($status);
            } catch (NoSuchEntityException $exception) {
                return '';
            }
        }

        return '';
    }

    /**
     * @param Status $status
     * @return string
     */
    private function addStatusData(Status $status)
    {
        $userId = (int) $status->getData('user_id');

        $user = $this->userProvider->getUser($userId);

        return $user->getFirstName() . ' is currently editing';
    }
}
