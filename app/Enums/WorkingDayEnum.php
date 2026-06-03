<?php

namespace App\Enums;

enum WorkingDayEnum: string
{
    case MONDAY = 'mon';
    case TUESDAY = 'tue';
    case WEDNESDAY = 'wed';
    case THURSDAY = 'thu';
    case FRIDAY = 'fri';
    case SATURDAY = 'sat';
    case SUNDAY = 'sun';

    /**
     * Get the name of the working day
     *
     * @param string $day
     * @return string
     */
    public static function getNameByKey(string $day): string
    {
        return match ($day) {
            self::MONDAY->value => __('company.monday'),
            self::TUESDAY->value => __('company.tuesday'),
            self::WEDNESDAY->value => __('company.wednesday'),
            self::THURSDAY->value => __('company.thursday'),
            self::FRIDAY->value => __('company.friday'),
            self::SATURDAY->value => __('company.saturday'),
            self::SUNDAY->value => __('company.sunday'),
            default => 'UNKNOWN',
        };
    }

    /**
     * Get all day
     * @return array
     */
    public static function getAllDay(): array
    {
        return array(
            'mon' => __('company.monday'),
            'tue' => __('company.tuesday'),
            'wed' => __('company.wednesday'),
            'thu' => __('company.thursday'),
            'fri' => __('company.friday'),
            'sat' => __('company.saturday'),
            'sun' => __('company.sunday'),
        );
    }
}
