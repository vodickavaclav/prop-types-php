<?php

namespace Prezly\PropTypes\Checker;

use Prezly\PropTypes\Exception\PropTypeException;

final class AnyType extends TypeChecker {

    /**
     * {@inheritDoc}
     */
    public function validate(array $props, string $propName, string $propFullName): ?PropTypeException {
        return null;
    }
}
