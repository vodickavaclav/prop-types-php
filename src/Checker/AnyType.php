<?php

namespace Guym4c\PropTypes\Checker;

use Guym4c\PropTypes\Exception\PropTypeException;

final class AnyType extends TypeChecker {

    /**
     * {@inheritDoc}
     */
    public function validate(array $props, string $propName, string $propFullName): ?PropTypeException {
        return null;
    }
}
