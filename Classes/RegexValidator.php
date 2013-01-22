<?php

/**
 * @file Classes/ca.bueller.Formation/RegexValidator
 * @copyright Copyright (c) 2012 Matt Ferris
 * @author Matt Ferris <matt@bueller.ca>
 */

namespace ca\bueller\Formation;

class RegexValidator implements iValidator
{
    /**
     * @var string
     */
    protected $pattern;


    /**
     * @param string $pattern
     * @return void
     */
    public function __construct ( $pattern )
    {
        if (empty($pattern))
        {
            throw new \InvalidArgumentException('$pattern expects non-empty string');
        }

        $this->pattern = $pattern;
    }


    /**
     * @param mixed $value
     * @return bool
     */
    public function validate ( $value )
    {
        $isValid = false;
        if (preg_match('/'.$this->pattern.'/', $value))
        {
            $isValid = true;
        }
        return $isValid;
    }
}
