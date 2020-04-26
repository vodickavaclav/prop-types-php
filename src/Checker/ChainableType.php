<?php

namespace Guym4c\PropTypes\Checker;

use Guym4c\PropTypes\Exception\PropTypeException;

final class ChainableType extends TypeChecker {

    private TypeChecker $checker;

    private bool $isRequired;

    private bool $isNullable;

    public function __construct(TypeChecker $checker, bool $isRequired = false, bool $isNullable = false) {
        $this->checker = $checker;
        $this->isRequired = $isRequired;
        $this->isNullable = $isNullable;
    }

    /**
     * @param array  $props
     * @param string $propName
     * @param string $propFullName
     * @return PropTypeException|null Exception is returned if prop type is invalid
     */
    public function validate(array $props, string $propName, string $propFullName): ?PropTypeException {
        if (!array_key_exists($propName, $props)) {
            if ($this->isRequired) {
                return new PropTypeException(
                    $propName,
                    "The property `{$propFullName}` is marked as required, but is not defined."
                );
            }
            return null;
        }

        if ($props[$propName] === null) {
            if (!$this->isNullable) {
                return new PropTypeException(
                    $propName,
                    "The property `{$propFullName}` is marked as not-null, but its value is `null`."
                );
            }
            return null;
        }

        return $this->checker->validate($props, $propName, $propFullName);
    }

    public function isRequired(): self {
        $this->isRequired = true;
        return $this;
    }

    public function isNullable(): self {
        $this->isNullable = true;
        return $this;
    }
}
