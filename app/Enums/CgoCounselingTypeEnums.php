<?php

namespace App\Enums;

enum CgoCounselingTypeEnums: int {
    case ONLINE = 1;
    case OFFLINE_CGO = 2;
    case OFFLINE = 3;

    /**
     * Get the name of the cgo counseling type
     *
     * @param $cgoCounselingType
     * @return string
     */
    public static function getCgoCounselingTypeName($cgoCounselingType): string
    {
        switch ($cgoCounselingType) {
            case self::ONLINE:
                return __('cgo.online');
            case self::OFFLINE_CGO:
                return __('cgo.offline_cgo');
            case self::OFFLINE:
                return __('cgo.offline');
            default:
                return 'UNKNOWN';
        }
    }

    public static function getKeyByName(string $name)
    {
        switch ($name) {
            case 'online':
                return self::ONLINE;
            case 'offline_cgo':
                return self::OFFLINE_CGO;
            case 'offline':
                return self::OFFLINE;
            default:
                return 0;
        }
    }
}
