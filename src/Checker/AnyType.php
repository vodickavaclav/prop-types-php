<?php

namespace Prezly\PropTypes\Checker;

use Prezly\PropTypes\Exception\PropTypeException;

final class AnyType implements TypeChecker {
    /**
     * @param array  $props
     * @param string $prop_name
     * @param string $prop_full_name
     * @return PropTypeException|null Exception is returned if prop type is invalid
     */
    public function validate(array $props, string $prop_name, string $prop_full_name): ?PropTypeException {
        return null;
    }
}
