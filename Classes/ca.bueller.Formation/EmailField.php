<?php

/**
 * @file Classes/ca.bueller.Formation/EmailField.php
 * @copyright Copyright (c) 2012 Matt Ferris
 * @author Matt Ferris <matt@bueller.ca>
 */

namespace ca\bueller\Formation;

class EmailField extends FormField
{
    /**
     * @param string $name
     * @param bool $required
     * @return void
     */
    public function __construct ( $name, $required = false )
    {
        parent::__construct($name, $required, new RegexValidator('^[^\@]+@[a-zA-Z-.]+\.[a-zA-Z]{2,5}$')); 
    }
}
