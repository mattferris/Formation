<?php

use \ca\bueller\Formation\FormField;

class FormFieldTest extends PHPUnit_Framework_TestCase
{
    public function testConstructorDefaults ()
    {
        $field = new FormField('name');
        $this->assertEquals($field->getName(), 'name');
        $this->assertEquals($field->getValue(), NULL);
        $this->assertEquals($field->isRequired(), false);
        $this->assertEquals($field->isValid(), true);
    }


    /**
     * @depends testConstructorDefaults
     */
    public function testConstructorArguments ()
    {
        $field = new FormField('name', true);
        $this->assertEquals($field->isRequired(), true);
    }


    /**
     * @depends testConstructorArguments
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage $name expects non-empty string
     */
    public function testConstructorNameException ()
    {
        $field = new FormField('');
    }


    /**
     * @depends testConstructorArguments
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage $required expects bool
     */
    public function testConstructorRequiredArgumentException ()
    {
        $field = new FormField('name', 1);
    }


    /**
     * @depends testConstructorDefaults
     */
    public function testSetValue ()
    {
        $field = new FormField('name');
        $field->setValue('foo');
        $this->assertEquals($field->getValue(), 'foo');
    }
}
