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
     * @param bool $required
     * @return void
     */
    public function addField ( FormField $field, $required = false )
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
            if ($value !== NULL)
            {
                $field->setValue($value);
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
