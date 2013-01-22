<?php

use \ca\bueller\Formation\Form,
    \ca\bueller\Formation\FormField,
    \ca\bueller\Formation\RegexValidator,
    \ca\bueller\Formation\FormEvents;

class FormTest extends PHPUnit_Framework_TestCase
{
    protected $event = NULL;


    public function testGetField ()
    {
        $form = new Form(array('foo'=>'bar'));
        $form->addField(new FormField('foo'));
        $this->assertInstanceOf('\\ca\\bueller\\Formation\\FormField', $form->getField('foo'));
    }


    /**
     * @depends testGetField
     */
    public function testNullFromGetFieldWhenNotSpecified ()
    {
        $form = new Form(array());
        $this->assertEquals($form->getField('foo'), NULL);
    }


    public function testRaiseValidationFailedEvent ()
    {
        FormEvents::registerHandler('ValidationFailed', array($this, 'captureEvent'));

        $form = new Form(array('foo'=>'bar'));
        $field = new FormField('foo', true, new RegexValidator('^baz$'));
        $form->addField($field);

        $this->assertFalse($form->validate());
        $this->assertInstanceOf('\\ca\\bueller\\Formation\\ValidationFailed', $this->event);
        $this->assertEquals($this->event->getField(), $field);

        $this->event = NULL;
    } 


    public function testRaiseRequiredFieldEmptyEvent ()
    {
        FormEvents::registerHandler('RequiredFieldEmpty', array($this, 'captureEvent'));

        $form = new Form(array('foo'=>''));
        $field = new FormField('foo', true);
        $form->addField($field);

        $this->assertFalse($form->validate());
        $this->assertInstanceOf('\\ca\\bueller\\Formation\\RequiredFieldEmpty', $this->event);
        $this->assertEquals($this->event->getField(), $field);

        $this->event = NULL;
    }


    public function captureEvent ( $event )
    {
        $this->event = $event;
    }
}

