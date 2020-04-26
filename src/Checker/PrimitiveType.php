<?php

namespace Guym4c\PropTypes\Checker;

use Guym4c\PropTypes\Exception\PropTypeException;

final class PrimitiveType extends TypeChecker {

    private string $expectedType;

    public function __construct(string $expectedType) {
        $this->expectedType = $expectedType;
    }

    public function validate(array $props, string $propName, string $propFullName): ?PropTypeException {
        $propValue = $props[$propName];

        if (gettype($propValue) !== $this->expectedType) {
            return PropTypeException::fromSimpleInvalidType(
                $propName, $propFullName, $this->expectedType, self::getActualPropType($propValue)
            );
        }
        return null;
    }
}
