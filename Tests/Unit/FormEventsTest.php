<?php

use \ca\bueller\Formation\FormEvents,
    \ca\bueller\Formation\ValidationFailed,
    \ca\bueller\Formation\FormField;

class FormEventsTest extends PHPUnit_Framework_TestCase
{
    protected $event = NULL;


    public function testRaiseEvent ()
    {
        FormEvents::registerHandler('ValidationFailed', array($this, 'captureEvent'));
        $field = new FormField('foo');
        FormEvents::raise(new ValidationFailed($field));

        $this->assertInstanceOf('\\ca\\bueller\\Formation\\ValidationFailed', $this->event);

        $this->event = NULL;
    }


    public function captureEvent ( $event )
    {
        $this->event = $event;
    }
}

