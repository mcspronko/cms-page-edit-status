<?php
/**
 * Copyright © Pronko Consulting (https://www.pronkoconsulting.com)
 * See LICENSE for the license details.
 */
declare(strict_types=1);

namespace Pronko\CmsPageEditStatus\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class Status
 */
class Status extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('pronko_cms_page_status', 'record_id');
//        $this->addUniqueField(['field' => 'user_id', 'title' => 'User ID is a unique field.']);
//        $this->addUniqueField(['field' => 'page_id', 'title' => 'Page ID is a unique field.']);
    }
}
