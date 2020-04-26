<?php

namespace Guym4c\PropTypes;

use InvalidArgumentException;
use Guym4c\PropTypes\Checker;
use Guym4c\PropTypes\Checker\ChainableType;
use Guym4c\PropTypes\Checker\TypeChecker;
use Guym4c\PropTypes\Exception\PropTypeException;

final class PropTypes {

    private const DEFAULT_OPTIONS = ['allow_extra_properties' => false];

    /**
     * @param TypeChecker[] $specs
     * @param array         $props
     * @param array         $options
     *        - bool "allow_extra_properties" (default: false)
     * @throws PropTypeException When a prop-type validation fails.
     * @throws InvalidArgumentException When invalid specs configuration was given.
     */
    public static function check(array $specs, array $props, array $options = []): void {
        $options = array_merge(self::DEFAULT_OPTIONS, $options);

        foreach ($specs as $key => $checker) {
            if (!$checker instanceof TypeChecker) {
                throw new InvalidArgumentException(sprintf(
                    'Invalid argument supplied to %s(). Expected an associative array of `%s` instances, but received `%s` at key `%s`.',
                    __FUNCTION__,
                    TypeChecker::class,
                    is_object($checker) ? get_class($checker) : gettype($checker),
                    $key
                ));
            }
        }

        if (!$options['allow_extra_properties']) {
            foreach (array_keys($props) as $prop_name) {
                if (!isset($specs[$prop_name])) {
                    throw new PropTypeException(
                        $prop_name,
                        "Unexpected extra property `{$prop_name}` supplied."
                    );
                }
            }
        }

        foreach ($specs as $prop_name => $checker) {
            $error = $checker->validate($props, $prop_name, $prop_name);
            if ($error !== null) {
                throw $error;
            }
        }
    }

    public static function any(): ChainableType {
        return new ChainableType(new Checker\AnyType());
    }

    public static function array(): ChainableType {
        return new ChainableType(new Checker\PrimitiveType('array'));
    }

    public static function arrayOf(TypeChecker $checker): ChainableType {
        return new ChainableType(new Checker\ArrayOfType($checker));
    }

    public static function bool(): ChainableType {
        return new ChainableType(new Checker\PrimitiveType('boolean'));
    }

    public static function callable(): ChainableType {
        return new ChainableType(new Checker\CallableType());
    }

    public static function callback(callable $callback): ChainableType {
        return new ChainableType(new Checker\CallbackType($callback));
    }

    public static function exact(array $shape): ChainableType {
        return new ChainableType(new Checker\StrictShapeType($shape));
    }

    public static function instanceOf(string $expected_class): ChainableType {
        return new ChainableType(new Checker\InstanceType($expected_class));
    }

    public static function int(): ChainableType {
        return new ChainableType(new Checker\PrimitiveType('integer'));
    }

    public static function iterable(): ChainableType {
        return new ChainableType(new Checker\IterableType());
    }

    public static function float(): ChainableType {
        return new ChainableType(new Checker\PrimitiveType('double'));
    }

    public static function number(): ChainableType {
        return self::oneOfType([self::int(), self::float()]);
    }

    public static function object(): ChainableType {
        return new ChainableType(new Checker\PrimitiveType('object'));
    }

    public static function oneOfType(array $checkers): ChainableType {
        return new ChainableType(new Checker\UnionType($checkers));
    }

    public static function oneOf(array $expected_values): ChainableType {
        return new ChainableType(new Checker\EnumType($expected_values));
    }

    public static function shape(array $shape): ChainableType {
        return new ChainableType(new Checker\ShapeType($shape));
    }

    public static function string(): ChainableType {
        return new ChainableType(new Checker\PrimitiveType('string'));
    }
}
