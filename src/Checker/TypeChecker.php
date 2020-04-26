<?php

namespace Prezly\PropTypes\Checker;

use Prezly\PropTypes\Exception\PropTypeException;

abstract class TypeChecker {

    /**
     * @param array  $props
     * @param string $propName
     * @param string $propFullName
     * @return PropTypeException|null Exception is returned if prop type is invalid
     */
    abstract public function validate(array $props, string $propName, string $propFullName): ?PropTypeException;

    protected static function getActualPropType($prop): string {
        return is_object($prop)
            ? get_class($prop)
            : gettype($prop);
    }
}
