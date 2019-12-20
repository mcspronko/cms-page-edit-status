<?php
/**
 * Copyright © Pronko Consulting (https://www.pronkoconsulting.com)
 * See LICENSE for the license details.
 */
declare(strict_types=1);

namespace Pronko\CmsPageEditStatus\Service;

use Magento\Cms\Api\Data\PageInterface;
use Magento\Cms\Api\PageRepositoryInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class CurrentPage
 */
class CurrentPage
{
    /**
     * @var PageRepositoryInterface
     */
    private $pageRepository;

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * CurrentPage constructor.
     * @param PageRepositoryInterface $pageRepository
     * @param RequestInterface $request
     */
    public function __construct(
        PageRepositoryInterface $pageRepository,
        RequestInterface $request
    ) {
        $this->pageRepository = $pageRepository;
        $this->request = $request;
    }

    /**
     * @return PageInterface
     * @throws LocalizedException|NoSuchEntityException
     */
    public function get(): PageInterface
    {
        return $this->pageRepository->getById($this->getPageId());
    }

    /**
     * @return int
     */
    private function getPageId(): int
    {
        return (int) $this->request->getParam('page_id');
    }
}
