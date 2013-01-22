<?php

/**
 * @file Classes/ca.bueller.Formation/iValidator.php
 * @copyright Copyright (c) 2012 Matt Ferris
 * @author Matt Ferris <matt@bueller.ca>
 */

namespace ca\bueller\Formation;

interface iValidator
{
    /**
     * @param mixed $value
     * @return bool
     */
    public function validate ( $value );
}
