<?php

/**
 * Copyright (c) 2013, Matt Ferris
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions are met:
 *
 * - Redistributions of source code must retain the above copyright notice,
 *   this list of conditions and the following disclaimer.
 *
 * - Redistributions in binary form must reproduce the above copyright notice,
 *   this list of conditions and the following disclaimer in the documentation
 *   and/or other materials provided with the distribution.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF
 * SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS
 * INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN
 * CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE)
 * ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @copyright Copyright (c) 2013 Matt Ferris
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
