<?php
/**
 * Copyright © Pronko Consulting (https://www.pronkoconsulting.com)
 * See LICENSE for the license details.
 */
declare(strict_types=1);

namespace Pronko\CmsPageEditStatus\Model\ResourceModel\Status;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Pronko\CmsPageEditStatus\Model\Status;
use Pronko\CmsPageEditStatus\Model\ResourceModel\Status as ResourceStatus;

/**
 * Class Collection
 */
class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(Status::class, ResourceStatus::class);
        parent::_construct();
    }
}
