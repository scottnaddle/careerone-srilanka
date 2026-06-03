<?php

namespace App\Enums\Trainee;

enum BookmarkTypeEnums: string {
    case MARK = 'MARK';
    case UNMARK = 'UNMARK';
    /**
     * Get the name of the cgo counseling status
     *
     * @param $bookmarkType
     * @return string
     */

    public static function getBookmarkType($bookmarkType): string
    {
        switch ($bookmarkType) {
            case self::MARK:
                return 'MARK';
            case self::UNMARK:
                return 'UNMARK';
            default:
                return 'UNKNOWN';
        }
    }
}
