<?php

namespace Prezly\PropTypes\Checker;

use Closure;
use InvalidArgumentException;
use Prezly\PropTypes\Exception\PropTypeException;

final class CallbackType extends TypeChecker {

    private Closure $callback;

    /**
     * @param callable $callback (array $props, string $prop_name, string $prop_full_name): ?PropTypeException()
     */
    public function __construct(callable $callback) {
        $this->callback = $callback;
    }

    /**
     * @param array  $props
     * @param string $propName
     * @param string $propFullName
     * @return PropTypeException|null Exception is returned if prop type is invalid
     */
    public function validate(array $props, string $propName, string $propFullName): ?PropTypeException {
        try {
            $error = ($this->callback)($props, $propName, $propFullName);
        } catch (PropTypeException $exception) {
            $error = $exception;
        } catch (InvalidArgumentException $exception) {
            $error = new PropTypeException($propName, $exception->getMessage(), $exception);
        }

        if ($error === null) {
            return null;
        }

        if ($error instanceof PropTypeException) {
            return $error;
        }

        throw new InvalidArgumentException(sprintf(
            'A callback() checker callback is allowed to return either `null` or `PropTypeException`, but `%s` returned instead.',
            self::getActualPropType($error)
        ));
    }
}
