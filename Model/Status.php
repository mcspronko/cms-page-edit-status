<?php
/**
 * Copyright © Pronko Consulting (https://www.pronkoconsulting.com)
 * See LICENSE for the license details.
 */
declare(strict_types=1);

namespace Pronko\CmsPageEditStatus\Model;

use Magento\Framework\Model\AbstractModel;
use Pronko\CmsPageEditStatus\Model\ResourceModel\Status as ResourceStatus;

/**
 * Class Status
 */
class Status extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(ResourceStatus::class);
        parent::_construct();
    }
}
