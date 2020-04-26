<?php

namespace Prezly\PropTypes\Checker;

use Prezly\PropTypes\Exception\PropTypeException;

class CallableType extends TypeChecker {

    public function validate(array $props, string $propName, string $propFullName): ?PropTypeException {
        $propValue = $props[$propName];

        if (!is_callable($propValue)) {
            return PropTypeException::fromSimpleInvalidType(
                $propName, $propFullName, 'callable', self::getActualPropType($propValue)
            );
        }

        return null;
    }
}