<?php

/**
 * @file Classes/ca.bueller.Formation/File.php
 * @copyright Copyright (c) 2012 Matt Ferris
 * @author Matt Ferris <matt@bueller.ca>
 */

namespace ca\bueller\Formation;

class Form
{
    /**
     * @var array
     */
    protected $fields = array();

    /**
     * @var array
     */
    protected $formData;


    /**
     * @param array $formData
     * @return void
     */
    public function __construct ( array $formData )
    {
        $this->formData = $formData;
    }


    /**
     * @param string $name
     * @return FormField
     */
    public function getField ( $name )
    {
        if (empty($name))
        {
            throw new \InvalidArgumentException('$name expects non-empty string');
        }
        $return = NULL;
        if (array_key_exists($name, $this->fields))
        {
            $return = $this->fields[$name];
        }
        return $return;
    }


    /**
     * @param array $formData
     * @return void
     */
    public function setFormData ( array $formData )
    {
        $this->formData = $formData;
    }


    /**
     * @param FormField $field
     * @return void
     */
    public function addField ( FormField $field )
    {
        $this->fields[$field->getName()] = $field;
    }


    /**
     * @return bool
     */
    public function validate ()
    {
        $valid = true;
        foreach ($this->fields as $name => $field)
        {
            $value = NULL;
            if (array_key_exists($name, $this->formData))
            {
                $value = $this->formData[$name];
            }
            $field->setValue($value);
            if ($value === NULL && $field->isRequired())
            {
                FormEvents::raise(new RequiredFieldEmpty($field));
                $valid = false;
            }
            elseif ($value !== NULL)
            {
                if (empty($value))
                {
                    if ($field->isRequired())
                    {
                        FormEvents::raise(new RequiredFieldEmpty($field));
                        $valid = false;
                    }
                }
                elseif (!$field->isValid())
                {
                    FormEvents::raise(new ValidationFailed($field));
                    $valid = false;
                }
            }
        }
        return $valid;
    }
}
