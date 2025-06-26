<?php

namespace Guym4c\PropTypes\Exception;

use InvalidArgumentException;
use Throwable;

class PropTypeException extends InvalidArgumentException {

    private string $prop_name;

    public function __construct(string $propName, string $message, ?Throwable $previous = null) {
        parent::__construct($message, 0, $previous);
        $this->prop_name = $propName;
    }

    public function getPropName(): string {
        return $this->prop_name;
    }

    public static function fromSimpleInvalidType(
        string $propName,
        string $propFullName,
        string $expectedType,
        string $actualType
    ): self {
        return new self(
            $propName,
            "Invalid property `{$propFullName}` of type `{$actualType}` supplied, expected `{$expectedType}`."
        );
    }
}
