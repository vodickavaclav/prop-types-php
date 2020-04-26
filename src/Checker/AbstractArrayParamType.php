<?php

namespace Prezly\PropTypes\Checker;

use InvalidArgumentException;

abstract class AbstractArrayParamType extends TypeChecker {

    /** @var array TypeChecker[] */
    protected array $types;

    public function __construct(array $types) {
        foreach ($types as $key => $checker) {
            if (!$checker instanceof TypeChecker) {
                throw new InvalidArgumentException(sprintf(
                    "Invalid argument supplied to shape(). Expected an associative array of %s instances, but received %s at key `{$key}`",
                    TypeChecker::class,
                    self::getActualPropType($checker)
                ));
            }
        }
        $this->types = $types;
    }
}