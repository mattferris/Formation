<?php

/**
 * @file Classes/ca.bueller.Formation/iFormField.php
 * @copyright Copyright (c) 2012 Matt Ferris
 * @author Matt Ferris <matT@bueller.ca>
 */

namespace ca\bueller\Formation;

interface iFormField
{
    /**
     * @return string
     */
    public function getName ();

    /**
     * @return mixed
     */
    public function getValue ();

    /**
     * @param mixed $value
     * @return void
     */
    public function setValue ( $value );

    /**
     * @return bool
     */
    public function isValid ();
}
