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

	/**
	 * Get midnight timezones
	 *
	 * @param string $currentTime
	 *
	 * @return array
	 */
	public function getMidnightTimeZones(string $currentTime) {
		$midnightZones = [];
		foreach(timezone_identifiers_list() as $zone) {
			$dateTime = Carbon::createFromFormat(config('settings.datetime_format'), $currentTime, config('app.timezone'));
			$dateTime->setTimezone($zone);
			\Log::debug(print_r($dateTime->hour));
		    // it's midnight in this zone
			if($dateTime->hour == 0) {
				$midnightZones[] = $zone;
			}
		}
		return $midnightZones;
	}
}