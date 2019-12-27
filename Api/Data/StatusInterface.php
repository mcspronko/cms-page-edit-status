<?php
/**
 * Copyright © Pronko Consulting (https://www.pronkoconsulting.com)
 * See LICENSE for the license details.
 */
declare(strict_types=1);

namespace Pronko\CmsPageEditStatus\Api\Data;

/**
 * Interface StatusInterface
 */
interface StatusInterface
{
    const CODE_OPEN = 'open';
    const CODE_EDIT = 'edit';
    const CODE_CLOSED = 'closed';
    const CODE_MODIFIED = 'modified';
    const CODE_NOT_MODIFIED = 'not_modified';
}
