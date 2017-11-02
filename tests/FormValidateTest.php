<?php
/**
 * Author: Luis Adrián Chávez Fregoso
 * Email: biolacf@gmail.com
 * Date: 02/11/2017
 */

class FormValidateTest extends PHPUnit_Framework_TestCase {

	public function testIsThereAnySyntaxError () {
		$var = new lacf95\FormValidate\FormValidate;
		$this->assertTrue(is_object($var), "No syntax erros in class");
		unset($var);
	}

	public function testValidateInput () {
		$var = new lacf95\FormValidate\FormValidate([
			"url" => null
		]);
		$input = new lacf95\FormValidate\Input("url", "url", "string", false);
		$validate = $var->validateInput($input);
		$this->assertTrue(is_null($validate), "Url should be null");
		$input->setRequired(true);
		$validate = $var->validateInput($input);
		$this->assertFalse($validate, "When url required can't be null, returning false");
		unset($var);
		unset($input);
		unset($validate);
	}

	public function testValidateInputArray () {
		$FormValidate = new lacf95\FormValidate\FormValidate([
			"item" => 123,
			"url" => null,
			"active" => 1
		]);
		$inputArray = array(
			new lacf95\FormValidate\Input("itemID", "item", "id", true),
			new lacf95\FormValidate\Input("url", "url", "string", false),
			new lacf95\FormValidate\Input("active", "active", "bool", true)
		);
		$validate = $FormValidate->validateInputArray($inputArray);
		$this->assertArrayHasKey("url", $validate, "Even when url is sent as null, should be valid because is not required");
		$this->assertEquals(1, $validate["active"], "Even when active is validated as bool, keeps its original value");
		unset($FormValidate);
		unset($inputArray);
		unset($validate);
	}
}