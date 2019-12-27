<?php
/**
 * Copyright © Pronko Consulting (https://www.pronkoconsulting.com)
 * See LICENSE for the license details.
 */
declare(strict_types=1);

namespace Pronko\CmsPageEditStatus\Ui\Listing\Column\DocumentStatus;

use Magento\Framework\Exception\NoSuchEntityException;
use Pronko\CmsPageEditStatus\Model\Status;
use Pronko\CmsPageEditStatus\Service\StatusProvider;
use Pronko\CmsPageEditStatus\Service\UserProvider;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;

/**
 * Class Value
 */
class Value
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
     * @var TimezoneInterface
     */
    private $timezone;

    /**
     * Value constructor.
     * @param StatusProvider $statusProvider
     * @param UserProvider $userProvider
     * @param TimezoneInterface $timezone
     */
    public function __construct(
        StatusProvider $statusProvider,
        UserProvider $userProvider,
        TimezoneInterface $timezone
    ) {
        $this->statusProvider = $statusProvider;
        $this->userProvider = $userProvider;
        $this->timezone = $timezone;
    }

    /**
     * @param int $pageId
     * @return string
     */
    public function get(int $pageId): string
    {
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
        try {
            $user = $this->userProvider->getById((int)$status->getData('user_id'));
            $firstName = $user->getFirstName();
        } catch (NoSuchEntityException $exception) {
            $firstName = 'Anonymous';
        }

        $documentStatus = $status->getData('status');
        if ('open' === $documentStatus) {
            return $firstName . ' is viewing';
        } elseif ('modified' === $documentStatus) {
            $timeAgo = $this->getTimeElapsed($status->getData('updated_at'));
            return $firstName . ' modified ' . $timeAgo;
        } elseif ('not_modified' === $documentStatus) {
            $timeAgo = $this->getTimeElapsed($status->getData('updated_at'));
            return $firstName . ' opened ' . $timeAgo;
        } elseif ('closed' === $documentStatus) {
            $timeAgo = $this->getTimeElapsed($status->getData('updated_at'));
            return $firstName . ' edited ' . $timeAgo;
        } elseif ('edit' === $documentStatus) {
            return $firstName . ' has been editing since ' . $status->getData('updated_at');
        } else {
            return '';
        }
    }

    /**
     * @param string $datetime
     * @return string
     */
    private function getTimeElapsed($datetime): string
    {
        $now = $this->timezone->date();
        $ago = $this->timezone->date($datetime);

        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = [
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'min',
            's' => 'sec',
        ];
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                if ($k === 's' & $diff->$k < 59) {
                    unset($string[$k]);
                } else {
                    $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
                }
            } else {
                unset($string[$k]);
            }
        }

        $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }
}
