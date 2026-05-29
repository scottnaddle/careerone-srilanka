<?php

namespace App\Enums;

enum JobStatusEnum: int {
	case CANCEL = 0;
	case PROGRESS = 1;
	case COMPLETED = 2;

	/**
	 * Get the name of the job status
	 *
	 * @param $status
	 * @return string
	 */
	public static function getNameByKey($status): string
	{
		return match ($status) {
			self::CANCEL->value =>getCodeNameByCodeId('job_status', self::CANCEL->value),
			self::PROGRESS->value => getCodeNameByCodeId('job_status', self::PROGRESS->value),
			self::COMPLETED->value => getCodeNameByCodeId('job_status', self::COMPLETED->value),
			default => 'UNKNOWN',
		};
	}

	/**
	 * Get the key of the job status
	 *
	 * @param string $name
	 * @return int
	 */
	public static function getKeyByName(string $name) :int
	{
		return match ($name) {
			'cancel' => self::CANCEL->value,
			'progress' => self::PROGRESS->value,
			'completed'=>self::COMPLETED->value,
			default => 0,
		};
	}

	/**
	 * Get all status
	 *
	 * @return array
	 */
	public static function getAllStatus(): array {
		return [
			self::CANCEL->value => getCodeNameByCodeId('job_status', self::CANCEL->value) ?? __('company.cancel'),
			self::PROGRESS->value => getCodeNameByCodeId('job_status', self::PROGRESS->value) ?? __('company.progress'),
			self::COMPLETED->value => getCodeNameByCodeId('job_status', self::COMPLETED->value) ?? __('company.completed'),
		];
	}
	

}
