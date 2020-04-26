<?php

namespace Prezly\PropTypes\Checker;

use Prezly\PropTypes\Exception\PropTypeException;

class ShapeType extends AbstractArrayParamType {

    /**
     * @{@inheritDoc}
     */
    public function validate(array $props, string $propName, string $propFullName): ?PropTypeException {
        $propValue = $props[$propName];

        $error = self::checkForArrayAsProp($propValue, $propName, $propFullName);

        if (!empty($error)) {
            return $error;
        }

        foreach ($this->types as $key => $checker) {
            $error = $checker->validate($propValue, (string)$key, "{$propFullName}.{$key}");

            if ($error !== null) {
                return new PropTypeException($propName, $error->getMessage(), $error);
            }
        }

        return null;
    }

    protected static function checkForArrayAsProp($propValue, string $propName, string $propFullName): ?PropTypeException {
        if (!is_array($propValue)) {
            return new PropTypeException(
                $propName,
                sprintf(
                    "Invalid property `{$propFullName}` of type `%s` supplied, expected an associative array.",
                    gettype($propValue)
                )
            );
        }
        return null;
    }
}
