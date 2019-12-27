<?php
/**
 * Copyright © Pronko Consulting (https://www.pronkoconsulting.com)
 * See LICENSE for the license details.
 */
declare(strict_types=1);

namespace Pronko\CmsPageEditStatus\Plugin;

use Magento\Cms\Controller\Adminhtml\Page\Save;
use Magento\Backend\Model\View\Result\Redirect;
use Magento\Framework\Exception\AlreadyExistsException;
use Magento\Framework\Exception\LocalizedException;
use Pronko\CmsPageEditStatus\Api\Data\StatusInterface;
use Pronko\CmsPageEditStatus\Service\CurrentPage;
use Pronko\CmsPageEditStatus\Service\PageStatusUpdater;

/**
 * Class SavePlugin
 */
class SavePlugin
{
    /**
     * @var CurrentPage
     */
    private $currentPage;

    /**
     * @var PageStatusUpdater
     */
    private $pageStatusUpdater;

    /**
     * SavePlugin constructor.
     * @param CurrentPage $currentPage
     * @param PageStatusUpdater $pageStatusUpdater
     */
    public function __construct(
        CurrentPage $currentPage,
        PageStatusUpdater $pageStatusUpdater
    ) {
        $this->currentPage = $currentPage;
        $this->pageStatusUpdater = $pageStatusUpdater;
    }

    /**
     * @param Save $controller
     * @param Redirect $resultRedirect
     * @return Redirect
     * @throws AlreadyExistsException|LocalizedException
     */
    public function afterExecute(
        Save $controller,
        Redirect $resultRedirect
    ) {
        if ($controller->getRequest()->getParam('back') === 'duplicate') {
            $this->pageStatusUpdater->execute(StatusInterface::CODE_MODIFIED);
        } elseif ($controller->getRequest()->getParam('back')) {
            // do nothing
        } else {
            $this->pageStatusUpdater->execute(StatusInterface::CODE_MODIFIED);
        }

        return $resultRedirect;
    }
}

