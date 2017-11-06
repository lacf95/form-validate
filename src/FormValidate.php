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
		$result = array(
			"isValid" => true,
			"validFields" => array(),
			"invalidFields" => array()
		);
		foreach ($inputs as $input) {
			$currentInput = $this->validateInput($input);
			if ($currentInput["isValid"]) {
				$result["validFields"] = array_merge($result["validFields"], $currentInput["validFields"]);
			} else {
				$result["isValid"] = false;
				$result["invalidFields"] = array_merge($result["invalidFields"], $currentInput["invalidFields"]);
			}
		}
		return $result;
	}

	/**
	 * @param Input $input
	 * @return bool|mixed
	 */
	public function validateInput (Input $input) {
		$result = array(
			"isValid" => true,
			"validFields" => array(),
			"invalidFields" => array()
		);
		if ($input->isRequired()) {
			if ($this->validate($input)) {
				$result["validFields"][$input->getName()] = $this->inputArray[$input->getValue()];
			} else {
				$result["isValid"] = false;
				$result["invalidFields"][$input->getName()] = $this->inputArray[$input->getValue()];
			}
		} else {
			if (array_key_exists($input->getValue(), $this->inputArray)) {
				if ($input->isNullable()) {
					if ($this->inputArray[$input->getValue()] === null) {
						$result["validFields"][$input->getName()] = null;
					} else {
						if ($this->validate($input)) {
							$result["validFields"][$input->getName()] = $this->inputArray[$input->getValue()];
						} else {
							$result["isValid"] = false;
							$result["invalidFields"][$input->getName()] = $this->inputArray[$input->getValue()];
						}
					}
				} else {
					if ($this->validate($input)) {
						$result["validFields"][$input->getName()] = $this->inputArray[$input->getValue()];
					} else {
						$result["isValid"] = false;
						$result["invalidFields"][$input->getName()] = $this->inputArray[$input->getValue()];
					}
				}
			}
		}
		return $result;
	}
}