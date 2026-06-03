<?php 
namespace App\Services;

class CGOApprovalService
{
    public static int $totalCgo = 0;

    public static function setTotalCgo(int $count)
    {
       
        self::$totalCgo = $count;
    }

    public static function getTotalCgo(): int
    {
        return self::$totalCgo;
    }
}

