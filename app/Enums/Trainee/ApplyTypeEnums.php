<?php

namespace App\Enums\Trainee;

enum ApplyTypeEnums: string {
    case APPLY = 'APPLY';
    case UNAPPLY = 'UNAPPLY';
    /**
     * Get the name of the cgo counseling status
     *
     * @param $bookmarkType
     * @return string
     */

    public static function getApplyType($applyType): string
    {
        switch ($applyType) {
            case self::APPLY:
                return 'APPLY';
            case self::UNAPPLY:
                return 'UNAPPLY';
            default:
                return 'UNKNOWN';
        }
    }
}
