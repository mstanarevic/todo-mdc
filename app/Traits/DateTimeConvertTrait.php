<?php
namespace App\Traits;

use Carbon\Carbon;

trait DateTimeConvertTrait {

	/**
	 * Convert given timestamp to server timezone if needed
	 *
	 * @param string $timestamp
	 * @param string $timezone
	 *
	 * @return string
	 */
	public function maybeConvertToServerTimezone(string $timestamp, string $timezone) {
		if(config('app.timezone') != $timezone) {
			$dateTime = Carbon::createFromFormat(config('settings.datetime_format'), $timestamp, $timezone);
			return $dateTime->setTimezone(config('app.timezone'))->format(config('settings.datetime_format'));
		} else {
			return $timestamp;
		}
	}

	/**
	 * Convert given timestamp to given timezone from servers timezone
	 * if needed
	 *
	 * @param string $timestamp
	 * @param string $timezone
	 *
	 * @return string
	 */
	public function maybeConvertToTimezone(string $timestamp, string $timezone) {
		if(config('app.timezone') != $timezone) {
			$dateTime = Carbon::createFromFormat(config('settings.datetime_format'), $timestamp, config('app.timezone'));
			return $dateTime->setTimezone($timezone)->format(config('settings.datetime_format'));
		} else {
			return $timestamp;
		}
	}
}