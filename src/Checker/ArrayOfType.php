<?php

namespace Guym4c\PropTypes\Checker;

use Guym4c\PropTypes\Exception\PropTypeException;

final class ArrayOfType extends TypeChecker {

    private TypeChecker $checker;

    public function __construct(TypeChecker $checker) {
        $this->checker = $checker;
    }

    /**
     * @param array  $props
     * @param string $propName
     * @param string $propFullName
     * @return PropTypeException|null Exception is returned if prop type is invalid
     */
    public function validate(array $props, string $propName, string $propFullName): ?PropTypeException {
        $propValue = $props[$propName];

        if (!is_array($propValue)) {
            $prop_type = gettype($propValue);

            return new PropTypeException(
                $propName,
                "Invalid property `{$propFullName}` of type `{$prop_type}` supplied, expected an array."
            );
        }

        foreach (array_keys($propValue) as $index) {
            $error = $this->checker->validate($propValue, (string)$index, "{$propFullName}[{$index}]");
            if ($error !== null) {
                return $error;
            }
        }

        return null;
    }
}
