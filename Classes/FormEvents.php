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

class FormEvents
{
    /**
     * @var array
     */
    static public $handlers = array();


    /**
     * @param string $eventName
     * @param mixed $handler
     * @return void
     */
    static public function registerHandler ( $eventName, $handler )
    {
        if (empty($eventName))
        {
            throw new \InvalidArgumentException('$eventName expects non-empty string');
        }

        if (is_string($handler) && empty($handler))
        {
            throw new \InvalidArgumentException('$handler expects non-empty string or array');
        }

        if (is_array($handler) && count($handler) > 2)
        {
            throw new \InvalidArgumentException('$handler expects array with 2 elements');
        }

        if (!array_key_exists($eventName, self::$handlers))
        {
            self::$handlers[$eventName] = array();
        }

        self::$handlers[$eventName][] = $handler;
    }


    /**
     * @param iEvent $event
     * @return void
     */
    public function raise ( iEvent $event )
    {
        $eventName = get_class($event);

        // Isolate the class name from the namespace
        if (strpos($eventName, '\\'))
        {
            $parts = explode('\\', $eventName);
            $eventName = array_pop($parts);
        }

        if (array_key_exists($eventName, self::$handlers) && count(self::$handlers[$eventName]) > 0)
        {
            foreach (self::$handlers[$eventName] as $handler)
            {
                call_user_func($handler, $event);
            }
        }
    }
}
