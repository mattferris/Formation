<?php

/**
 * @file Classes/ca.bueller.Formation/RequiredFieldEmpty.php
 * @copyright (c) 2012 Matt Ferris
 * @author Matt Ferris <matt@bueller.ca>
 */

namespace ca\bueller\Formation;

class RequiredFieldEmpty implements iEvent
{
    /**
     * @var FormField
     */
    protected $field;


    /**
     * @param FormField $field
     * @return void
     */
    public function __construct ( FormField $field )
    {
        $this->field = $field;
    }


    /**
     * @return FormField
     */
    public function getField ()
    {
        return $this->field;
    }
}
