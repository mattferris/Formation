<?php

/**
 * @file Classes/ca.bueller.Formation/FormField.php
 * @copyright Copyright (c) 2012 Matt Ferris
 * @author Matt Ferris <matt@bueller.ca>
 */

namespace ca\bueller\Formation;

class FormField implements iFormField
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var mixed
     */
    protected $value;

    /**
     * @var iValidator
     */
    protected $validator;


    /**
     * @param string $name
     * @param iValidator $validator
     * @return void
     */
    public function __construct ( $name, iValidator $validator = NULL )
    {
        if (empty($name))
        {
            throw new \InvalidArgumentException('$name expects non-empty string');
        }

        $this->name = $name;
        $this->validator = $validator;
    }


    /**
     * @return string
     */
    public function getName ()
    {
        return $this->name;
    }


    /**
     * @return mixed
     */
    public function getValue ()
    {
        return $this->value;
    }


    /**
     * @param mixed $value
     * @return void
     */
    public function setValue ( $value )
    {
        $this->value = $value;
    }


    /**
     * @return bool
     */
    public function isValid ()
    {
        $isValid = true;

        if ($this->validator !== NULL)
        {
            $isValid = $this->validator->validate($this->value);
        }

        return $isValid;
    }
}
