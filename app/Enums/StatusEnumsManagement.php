<?php

namespace App\Enums;

enum StatusEnumsManagement: int {
    case PENDING_APPROVAL = 0;
    case APPROVED = 2;
    case NON_APPROVAL = 1;
//    case APPROVED_BY_PEER_REVIEW = 3;
//    case REJECTED_BY_PEER_REVIEW = 4;
    case APPROVED_BY_ADMIN = 5;
    case REJECTED_BY_ADMIN = 6;
    case APPROVED_BY_ASSOCIATION = 7;
    case REJECTED_BY_ASSOCIATION = 8;
    /**
     *
     * @param $statusManagement
     * @return string
     */


     public static function getStatusName($statusManagement): string
     {
         switch ($statusManagement) {
             case self::PENDING_APPROVAL->value:
                 return __('admin/status.pending_approval');
             case self::APPROVED->value:
                 return __('admin/status.approved');
             case self::NON_APPROVAL->value:
                 return __('admin/status.non_approval');
//             case self::APPROVED_BY_PEER_REVIEW->value:
//                 return __('admin/status.peer_reviewed_by_cgos');
//             case self::REJECTED_BY_PEER_REVIEW->value:
//                 return __('admin/status.rejected_by_cgos');
             case self::APPROVED_BY_ADMIN->value:
                 return __('admin/status.approved_by_tvec');
             case self::REJECTED_BY_ADMIN->value:
                 return __('admin/status.rejected_by_tvec');
             case self::APPROVED_BY_ASSOCIATION->value:
                 return __('admin/status.approved_by_association');
             case self::REJECTED_BY_ASSOCIATION->value:
                 return __('admin/status.rejected_by_association');
             default:
                 return 'UNKNOWN';
         }
     }

    public static function getKeyByName(string $name)
    {
        switch ($name) {
            case 'pending_approval':
                return self::PENDING_APPROVAL;
            case 'approved':
                return self::APPROVED;
            case 'non_approval':
                return self::NON_APPROVAL;
//            case 'peer_reviewed_by_cgos':
//                return self::APPROVED_BY_PEER_REVIEW;
            case 'approved_by_tvec':
                return self::APPROVED_BY_ADMIN;
            case 'approved_by_association':
                return self::APPROVED_BY_ASSOCIATION;
            default:
                return 0;
        }
    }
}
