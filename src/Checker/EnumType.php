<?php

namespace Prezly\PropTypes\Checker;

use Prezly\PropTypes\Exception\PropTypeException;
use Prezly\PropTypes\StringifyTrait;

final class EnumType extends TypeChecker {

    use StringifyTrait;

    private array $expectedValues;

    /**
     * @param mixed[] $expectedValues
     */
    public function __construct(array $expectedValues) {
        $this->expectedValues = $expectedValues;
    }

    /**
     * {@inheritDoc}
     */
    public function validate(array $props, string $propName, string $propFullName): ?PropTypeException {
        $propValue = $props[$propName];

        foreach ($this->expectedValues as $expected_value) {
            if ($propValue === $expected_value) {
                return null;
            }
        }

        return new PropTypeException(
            $propName,
            sprintf(
                "Invalid property `{$propFullName}` of value `%s` supplied, expected one of: %s.",
                self::stringifyValue($propValue),
                self::stringifyValue($this->expectedValues)
            )
        );
    }
}
