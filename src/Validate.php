<?php
/**
 * Author: Luis Adrián Chávez Fregoso
 * Email: biolacf@gmail.com
 * Date: 02/11/2017
 */

namespace lacf95\FormValidate;

/**
 * Class Validate
 * @package lacf95\FormValidate
 * Class with all current validations
 */
class Validate {
	const DATE_1 = "/^(19|20)\d\d([-\/])(0[1-9]|1[012])\\2(0[1-9]|[12]\d|3[01])+$/";
	const DATE_2 = "/^(0[1-9]|[12]\d|3[01])([-\/])(0[1-9]|1[012])\\2(19|20)\d\d+$/";
	const DATE_TIME_1 = "/^(19|20)\d\d([-\/])(0[1-9]|1[012])\\2(0[1-9]|[12]\d|3[01])([Tt\040]){1}([01][0-9]|2[0-3])([:])([0-5][0-9])\\7([0-5][0-9])+$/";
	const DATE_TIME_2 = "/^(0[1-9]|[12]\d|3[01])([-\/])(0[1-9]|1[012])\\2(19|20)\d\d([Tt\040]){1}([01][0-9]|2[0-3])([:])([0-5][0-9])\\7([0-5][0-9])+$/";
	const EMAIL = "/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/";
	const MONTH = "/^(0[2469]|1[1])+$/";
	const NAME = "/^[a-zA-ZàáâäãåąčćęèéêëėįìíîïłńòóôöõøùúûüųūÿýżźñçčšžÀÁÂÄÃÅĄĆČĖĘÈÉÊËÌÍÎÏĮŁŃÒÓÔÖÕØÙÚÛÜŲŪŸÝŻŹÑßÇŒÆČŠŽ∂ð\\\/s,.'-]+$/u";
	const PHONE_NUMBER = "/^[0-9]{10}+$/";
	const TIME = "/^([01][0-9]|2[0-3])([:])([0-5][0-9])\\2([0-5][0-9])/";
	const PATH = "/^(?:[a-zA-Z]\:|\/[\w\.]+\/[\w.$]+)\/(?:[\w]+\/)*\w([\w.])+/";
	const ZIPCODE = "/^[0-9]{5}$/";

	/**
	 * @param $value
	 * @return bool
	 */
	static public function date ($value) {
		if (preg_match(self::DATE_1, $value) || preg_match(self::DATE_2, $value)) {
			$delimiter = (strpos($value, '/') === false ? '-' : '/');
			$dateElements = explode($delimiter, $value);
			$day = (strlen($dateElements[0]) === 2 ? $dateElements[0] : $dateElements[2]);
			if (!preg_match(self::MONTH, $dateElements[1]) || ($dateElements[1] !== '02' && $day !== '31'))
				return true;
			else if ($dateElements[1] === '02') {
				$year = (strlen($dateElements[0]) === 4 ? $dateElements[0] : $dateElements[2]);
				return ((!self::isLeapYear($year) && $day !== '29') || (self::isLeapYear($year) && $day !== '31'));
			}
		}
		return false;
	}

	/**
	 * @param $value
	 * @return bool
	 */
	static public function dateTime ($value) {
		return ((preg_match(self::DATE_TIME_1, $value) || preg_match(self::DATE_TIME_2, $value)) && self::date(substr($value, 0,10)));
	}

	/**
	 * @param $year
	 * @return bool
	 */
	static private function isLeapYear ($year) {
		$yearValue = intval($year);
		return ($yearValue % 400 === 0 || ($yearValue % 4 === 0 && $yearValue % 100 !== 0));
	}

	/**
	 * @param $value
	 * @param int $length
	 * @return bool
	 */
	static public function email ($value, $length = 0) {
		if ($length === 0) {
			return boolval(preg_match(self::EMAIL, $value));
		}
		return (preg_match(self::EMAIL, $value) && strlen($value) <= $length);
	}

	/**
	 * @param $value
	 * @return bool
	 */
	static public function id ($value) {
		return ((is_int($value) || ctype_digit($value)) && intval($value) > 0);
	}

	/**
	 * @param $value
	 * @return bool
	 */
	static public function int ($value) {
		return ((is_int($value) || ctype_digit($value)));
	}

	/**
	 * @param $value
	 * @param int $length
	 * @return bool
	 */
	static public function name ($value, $length = 0) {
		if ($length === 0) {
			return boolval(preg_match(self::NAME, $value));
		}
		return (preg_match(self::NAME, $value) && strlen($value) <= $length);
	}

	/**
	 * @param $value
	 * @return int
	 */
	static public function path ($value) {
		return preg_match(self::PATH, $value);
	}

	/**
	 * @param $value
	 * @param int $length
	 * @return bool
	 */
	static public function phoneNumber ($value, $length = 12) {
		return (preg_match(self::PHONE_NUMBER, $value) && strlen($value) <= $length);
	}

	/**
	 * @param $value
	 * @return bool
	 */
	static public function time ($value) {
		return boolval(preg_match(self::TIME, $value));
	}

	/**
	 * @param $value
	 * @return bool
	 */
	static public function zipcode ($value) {
		return boolval(preg_match(self::ZIPCODE, $value));
	}

	/**
	 * @param $value
	 * @param int $length
	 * @return bool|mixed
	 */
	static public function url ($value, $length = 0) {
		if ($length === 0) {
			return filter_var($value, FILTER_VALIDATE_URL);
		}
		return (filter_var($value, FILTER_VALIDATE_URL) && strlen($value) <= $length);
	}

	/**
	 * @param $value
	 * @return bool
	 */
	static public function double ($value) {
		return (floatval($value) ? true : false);
	}

	/**
	 * @param $value
	 * @param int $length
	 * @return bool
	 */
	static public function string ($value, $length = 0) {
		if ($length === 0) {
			return is_string($value);
		}
		return (is_string($value) && strlen($value) <= $length);
	}

	/**
	 * @param $value
	 * @return bool
	 */
	static public function bool ($value) {
		if ($value === 1 || $value === true || $value === '1' || $value === 'true') {
			return true;
		}
		return false;
	}
}