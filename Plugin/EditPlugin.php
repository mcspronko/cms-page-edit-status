<?php
/**
 * Copyright © Pronko Consulting (https://www.pronkoconsulting.com)
 * See LICENSE for the license details.
 */
declare(strict_types=1);

namespace Pronko\CmsPageEditStatus\Plugin;

use Magento\Cms\Controller\Adminhtml\Page\Edit;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\LocalizedException;
use Pronko\CmsPageEditStatus\Service\PageStatusUpdater;
use Psr\Log\LoggerInterface;

/**
 * Class EditPlugin
 */
class EditPlugin
{
    /**
     * @var PageStatusUpdater
     */
    private $pageStatusUpdater;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * EditPlugin constructor.
     * @param PageStatusUpdater $pageStatusUpdater
     * @param LoggerInterface $logger
     */
    public function __construct(
        PageStatusUpdater $pageStatusUpdater,
        LoggerInterface $logger
    ) {
        $this->pageStatusUpdater = $pageStatusUpdater;
        $this->logger = $logger;
    }

    /**
     * @param Edit $controller
     * @param ResultInterface $resultPage
     * @return ResultInterface
     */
    public function afterExecute(
        Edit $controller,
        $resultPage
    ) {
        try {
            $this->pageStatusUpdater->execute();
        } catch (LocalizedException $exception) {
            $this->logger->critical($exception);
        }

        return $resultPage;
    }
}
