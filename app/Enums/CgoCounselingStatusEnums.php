<?php

namespace App\Enums;

enum CgoCounselingStatusEnums: int {
    case REQUEST = 1;
    case CONFIRM = 2;
    case COMPLETED = 3;
    case CANCELED = 4;
    case RE_ASSIGN = 5;
    /**
     * Get the name of the cgo counseling status
     *
     * @param $cgoCounselingStatus
     * @return string
     */

    public static function getCgoCounselingStatusName($cgoCounselingStatus): string
    {
        switch ($cgoCounselingStatus) {
            case self::REQUEST->value:
                return __('cgo.request');
            case self::CONFIRM->value:
                return __('cgo.confirm');
            case self::COMPLETED->value:
                return __('cgo.completed');
            case self::CANCELED->value:
                return 'CANCELED';
           case self::RE_ASSIGN->value:
                    return 'RE_ASSIGN';
            default:
                return 'UNKNOWN';
        }
    }

    public static function getKeyByName(string $name)
    {
        switch ($name) {
            case 'request':
                return self::REQUEST;
            case 'confirm':
                return self::CONFIRM;
            case 'completed':
                return self::COMPLETED;
            case 'CANCELED':
                return self::CANCELED;
            default:
                return 0;
        }
    }
}
