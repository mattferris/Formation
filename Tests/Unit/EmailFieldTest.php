<?php

use \ca\bueller\Formation\EmailField;

class EmailFieldTest extends PHPUnit_Framework_TestCase
{
    public function testValidationOfValidEmail ()
    {
        $field = new EmailField('email');
        $field->setValue('test@example.com');
        $this->assertTrue($field->isValid());
    }


    public function testValidationOfEmailWithoutDomain ()
    {
        $field = new EmailField('email');
        $field->setValue('test@');
        $this->assertFalse($field->isValid());
    }
}

