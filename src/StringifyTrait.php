<?php

namespace Guym4c\PropTypes;

use stdClass;
use voku\helper\UTF8;

trait StringifyTrait {
    /**
     * @param mixed $value
     * @return string
     */
    private static function stringifyValue($value): string {
        if (is_null($value)) {
            return 'null';
        }

        if (is_bool($value)) {
            return $value ? 'true' : 'false';
        }

        if (is_int($value) || is_float($value)) {
            return (string)$value;
        }

        if (is_resource($value)) {
            return 'resource';
        }

        if (is_string($value)) {
            if (UTF8::strlen($value) > 100) {
                return sprintf(
                    '"%s..." (%s characters)',
                    UTF8::substr($value, 0, 80),
                    UTF8::strlen($value)
                );
            }
            return sprintf('"%s"', $value);
        }

        if (is_array($value)) {
            return self::stringifyArray($value);
        }

        if (is_object($value)) {
            return self::stringifyInstance($value);
        }

        return (string)$value;
    }

    private static function stringifyObject(stdClass $value): string {
        $struct = array_map(function ($value) {
            return self::stringifyValue($value);
        }, (array)$value);

        $pairs = [];
        foreach ($struct as $property => $value) {
            $pairs[] = "{$property}: {$value}";
        }
        return sprintf('{%s}', implode(', ', $pairs));
    }

    /**
     * @param object $value
     * @return string
     */
    private static function stringifyInstance($value): string {
        if ($value instanceof stdClass) {
            return sprintf('object %s', self::stringifyObject($value));
        }

        $class = get_class($value);
        if (method_exists($value, '__toString')) {
            return "instance of {$class} ({$value->__toString()})";
        }
        return "instance of {$class}";
    }

    private static function stringifyArray(array $value): string {
        $values = array_map(function ($value) {
            return self::stringifyValue($value);
        }, $value);

        return sprintf('[%s]', implode(', ', $values));
    }
}