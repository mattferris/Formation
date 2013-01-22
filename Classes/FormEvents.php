<?php

/**
 * Classes/ca.bueller.Formation/FormEvents.php
 * @copyright Copyright (c) 2012 Matt Ferris
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
