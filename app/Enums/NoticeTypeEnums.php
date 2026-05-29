<?php

namespace App\Enums;

enum NoticeTypeEnums: int
{
    case COMPETITION = 1;
    case JOB_FAIR = 2;
    case ANNOUNCEMENT = 3;

    public static function getNoticeTypeName($NoticeType): string
    {
        switch ($NoticeType) {
            case self::COMPETITION:
                return __('cgo.competition');
            case self::JOB_FAIR:
                return __('cgo.job_fair');
            case self::ANNOUNCEMENT:
                return __('cgo.announcement');
            default:
                return 'UNKNOWN';
        }
    }

    public static function getKeyByName($name)
    {
        switch ($name) {
            case 'competition':
                return self::COMPETITION;
            case 'job_fair':
                return self::JOB_FAIR;
            case 'announcement':
                return self::ANNOUNCEMENT;
            default:
                return 0;
        }
    }
}
