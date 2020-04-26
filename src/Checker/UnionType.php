<?php

namespace Guym4c\PropTypes\Checker;

use Guym4c\PropTypes\Exception\PropTypeException;

final class UnionType extends AbstractArrayParamType {

    /**
     * @param array  $props
     * @param string $propName
     * @param string $propFullName
     * @return PropTypeException|null Exception is returned if prop type is invalid
     */
    public function validate(array $props, string $propName, string $propFullName): ?PropTypeException {
        foreach ($this->types as $checker) {
            $checker_result = $checker->validate($props, $propName, $propFullName);
            if ($checker_result === null) {
                return null;
            }
        }

        return new PropTypeException(
            $propName,
            "Invalid `{$propFullName}` supplied, none of types matched."
        );
    }
}
