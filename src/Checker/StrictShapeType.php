<?php

namespace Guym4c\PropTypes\Checker;

use Guym4c\PropTypes\Exception\PropTypeException;

final class StrictShapeType extends ShapeType {

    /**
     * @{@inheritDoc}
     */
    public function validate(array $props, string $propName, string $propFullName): ?PropTypeException {
        $propValue = $props[$propName];

        $error = self::checkForArrayAsProp($propValue, $propName, $propFullName);

        if (!empty($error)) {
            return $error;
        }

        $combinedKeys = array_unique(
            array_merge(
                array_keys($propValue),
                array_keys($this->types)
            )
        );
        foreach ($combinedKeys as $key) {
            $checker = $this->types[$key] ?? null;

            if (empty($checker)) {
                return new PropTypeException(
                    $propName,
                    "Invalid property `{$propFullName}` with unexpected key `${key}` supplied."
                );
            }

            $error = $checker->validate($propValue, (string)$key, "{$propFullName}.{$key}");

            if ($error !== null) {
                return new PropTypeException($propName, $error->getMessage(), $error);
            }
        }

        return null;
    }
}
