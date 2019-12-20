<?php
/**
 * Copyright © Pronko Consulting (https://www.pronkoconsulting.com)
 * See LICENSE for the license details.
 */
declare(strict_types=1);

namespace Pronko\CmsPageEditStatus\Controller\Adminhtml\Status;

use Magento\Backend\App\Action;
use Pronko\CmsPageEditStatus\Api\Data\StatusInterface;
use Pronko\CmsPageEditStatus\Service\PageStatusUpdater;

/**
 * Class Update
 */
class Update extends Action
{
    /**
     * @var PageStatusUpdater
     */
    private $pageStatusUpdater;

    /**
     * Update constructor.
     * @param Action\Context $context
     * @param PageStatusUpdater $pageStatusUpdater
     */
    public function __construct(Action\Context $context, PageStatusUpdater $pageStatusUpdater)
    {
        $this->pageStatusUpdater = $pageStatusUpdater;
        parent::__construct($context);
    }

    public function execute()
    {
        $this->pageStatusUpdater->execute(StatusInterface::CODE_CLOSED);
    }
}
