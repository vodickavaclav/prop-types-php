<?php

namespace Prezly\PropTypes\Checker;

use Prezly\PropTypes\Exception\PropTypeException;

class IterableType extends TypeChecker {

    public function validate(array $props, string $propName, string $propFullName): ?PropTypeException {
        $propValue = $props[$propName];

        if (!is_iterable($propValue)) {
            return PropTypeException::fromSimpleInvalidType(
                $propName, $propFullName, 'iterable', self::getActualPropType($propValue)
            );
        }

        return null;
    }
}