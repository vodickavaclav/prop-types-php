<?php

namespace Guym4c\PropTypes\Checker;

use Guym4c\PropTypes\Exception\PropTypeException;

final class InstanceType extends TypeChecker {

    private string $expectedClass;

    public function __construct(string $expectedClass) {
        $this->expectedClass = $expectedClass;
    }

    /**
     * @param array  $props
     * @param string $propName
     * @param string $propFullName
     * @return PropTypeException|null Exception is returned if prop type is invalid
     */
    public function validate(array $props, string $propName, string $propFullName): ?PropTypeException {
        $propValue = $props[$propName];

        if (!$propValue instanceof $this->expectedClass) {
            return new PropTypeException(
                $propName,
                sprintf(
                    "Invalid property `{$propFullName}` of type `%s` supplied, expected instance of `{$this->expectedClass}`.",
                    self::getActualPropType($propValue))
            );
        }

        return null;
    }
}
