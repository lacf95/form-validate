<?php
/**
 * Author: Luis Adrián Chávez Fregoso
 * Email: biolacf@gmail.com
 * Date: 02/11/2017
 */

namespace lacf95\FormValidate;

/**
 * Class FormValidate
 * @package lacf95\FormValidate
 * Main library class, it's the interface for validating
 */
class FormValidate {

	/**
	 * @var mixed[]
	 */
	protected $inputArray;

	/**
	 * FormValidate constructor.
	 * @param mixed[] $inputArray
	 */
	public function __construct ($inputArray = array()) {
		$this->inputArray = $inputArray;
	}

	/**
	 * @param Input $input
	 * @return mixed
	 */
	protected function validate (Input $input) {
		if ($input->getLength() === 0) {
			return (call_user_func_array([new Validate(), "{$input->getType()}"], [$this->inputArray[$input->getValue()]]));
		}
		return (call_user_func_array([new Validate(), "{$input->getType()}"], [$this->inputArray[$input->getValue()], $input->getLength()]));
	}

	/**
	 * @param Input[] $inputs
	 * @return mixed
	 */
	public function validateInputArray ($inputs) {
		$result = array();
		foreach ($inputs as $input) {
			if ($input->getRequired()) {
				if ($this->validate($input)) {
					$result[$input->getName()] = $this->inputArray[$input->getValue()];
				} else {
					return false;
				}
			} else {
				if (array_key_exists($input->getValue(), $this->inputArray)) {
					if ($this->inputArray[$input->getValue()] === null) {
						$result[$input->getName()] = null;
					} else {
						if ($this->validate($input)) {
							$result[$input->getName()] = $this->inputArray[$input->getValue()];
						} else {
							return false;
						}
					}
				}
			}
		}
		return (count($result) > 0 ? $result : false);
	}

	/**
	 * @param Input $input
	 * @return bool|mixed
	 */
	public function validateInput (Input $input) {
		if (array_key_exists($input->getValue(), $this->inputArray)) {
			if ($input->getRequired()) {
				return ($this->validate($input) ? $this->inputArray[$input->getValue()] : false);
			} else {
				if ($this->inputArray[$input->getValue()] === null) {
					return null;
				}
				return ($this->validate($input) ? $this->inputArray[$input->getValue()] : false);
			}
		}
		return false;
	}
}