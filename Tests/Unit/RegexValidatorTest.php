<?php

use \ca\bueller\Formation\RegexValidator;

class RegexValidatorTest extends PHPUnit_Framework_TestCase
{
    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage $pattern expects non-empty string
     */
    public function testConstructorWithEmptyPattern ()
    {
        $validator = new RegexValidator('');
    }


    public function testValidateWithValidData ()
    {
        $validator = new RegexValidator('.');
        $this->assertTrue($validator->validate('a'));
    }


    public function testValidateWithInvalidData ()
    {
        $validator = new RegexValidator('.');
        $this->assertFalse($validator->validate(''));
    }
}
