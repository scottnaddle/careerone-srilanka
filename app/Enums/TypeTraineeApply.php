<?php

namespace App\Enums;

enum TypeTraineeApply: string {
	case APPLY = 'apply';
	case JOB_MATCH = 'job_match';
	case OJT_MATCH = 'ojt_match';

	/**
	 * Get the name of the type trainee apply
	 *
	 * @param $type
	 * @return string
	 */
	public static function getNameByKey($type): string
	{
		return match ($type) {
			self::APPLY->value => __('company.applied'),
			self::JOB_MATCH->value => __('company.job_matched'),
			self::OJT_MATCH->value => __('company.ojt_matched'),
			default => 'UNKNOWN',
		};
	}
}
