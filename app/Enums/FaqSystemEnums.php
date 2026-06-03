<?php

namespace App\Enums;

enum FaqSystemEnums: int {

    case TRAINEE = 1;
    case CGO = 2;
    case COMPANY = 3;

    /**
     * Get the name of the faq system
     *
     * @param int $faqSystem
     * @return string
     */
    public static function getFaqSystemName(int $faqSystem): string
    {
        switch ($faqSystem) {
            case self::TRAINEE:
                return 'TRAINEE';
            case self::CGO:
                return 'CGO';
            case self::COMPANY:
                return 'COMPANY';
            default:
                return 'UNKNOWN';
        }
    }

}
