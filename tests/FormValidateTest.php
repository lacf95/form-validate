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
		$input = new lacf95\FormValidate\Input("url", "url", "string", false, true);
		$validate = $var->validateInput($input);
		$this->assertTrue($validate["isValid"], "URL should be valid");
		$this->assertArrayHasKey("url", $validate["validFields"]);
		$input->setNullable(false);
		$validate = $var->validateInput($input);
		$this->assertFalse($validate["isValid"], "URL should not be valid, it can't be null");
		$this->assertArrayHasKey("url", $validate["invalidFields"]);
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
			new lacf95\FormValidate\Input("itemID", "item", "id", false),
			new lacf95\FormValidate\Input("url", "url", "string", false, true),
			new lacf95\FormValidate\Input("active", "active", "bool", false)
		);
		$validate = $FormValidate->validateInputArray($inputArray);
		$this->assertTrue($validate["isValid"], "Array should be valid");
		$this->assertArrayHasKey("url", $validate["validFields"], "Even when url is sent as null, should be valid because is not required");
		$this->assertEquals(1, $validate["validFields"]["active"], "Even when active is validated as bool, keeps its original value");
		unset($FormValidate);
		unset($inputArray);
		unset($validate);
	}
}