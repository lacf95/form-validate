<?php
/**
 * Author: Luis Adrián Chávez Fregoso
 * Email: biolacf@gmail.com
 * Date: 02/11/2017
 */

namespace lacf95\FormValidate;

/**
 * Class Input
 * @package lacf95\FormValidate
 * The input element is the basic object for validating
 */
class Input {
	/**
	 * @var string
	 */
	private $name;
	/**
	 * @var string
	 */
	private $value;
	/**
	 * @var string
	 */
	private $type;
	/**
	 * @var int
	 */
	private $length;
	/**
	 * @var bool
	 */
	private $required;

	/**
	 * Input constructor.
	 * @param string $name
	 * @param string $value
	 * @param string $type
	 * @param bool $required
	 * @param int $length
	 */
	public function __construct ($name, $value, $type, $required = true, $length = 0) {
		$this->name = $name;
		$this->value = $value;
		$this->type = $type;
		$this->required = $required;
		$this->length = $length;
	}

	/**
	 * @return string
	 */
	public function getName () {
		return $this->name;
	}

	/**
	 * @param string $name
	 */
	public function setName ($name) {
		$this->name = $name;
	}

	/**
	 * @return string
	 */
	public function getValue () {
		return $this->value;
	}

	/**
	 * @param string $value
	 */
	public function setValue ($value) {
		$this->value = $value;
	}

	/**
	 * @return string
	 */
	public function getType () {
		return $this->type;
	}

	/**
	 * @param string $type
	 */
	public function setType ($type) {
		$this->type = $type;
	}

	/**
	 * @return int
	 */
	public function getLength () {
		return $this->length;
	}

	/**
	 * @param int $length
	 */
	public function setLength ($length) {
		$this->length = $length;
	}

	/**
	 * @return bool
	 */
	public function getRequired () {
		return $this->required;
	}

	/**
	 * @param bool $required
	 */
	public function setRequired ($required) {
		$this->required = $required;
	}
}