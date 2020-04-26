# PropTypes.php

**A fork of [prezly/prop-types-php](https://github.com/prezly/prop-types-php). Please consider using the original package**

Complete PHP port of [React PropTypes](https://github.com/facebook/prop-types).

Runtime type checking for complex properties structures.

You can use prop-types to document the intended types of properties passed into your code. PropTypes will check props passed to your functions against those definitions, and throw an error if they don’t match.

## Installation

```
composer require prezly/prop-types
```

## Credit
This is a fork of [prezly/prop-types-php](https://github.com/prezly/prop-types-php).

This package adds:

   * Iterable proptype
   * Callable proptype
   * Number float/int shorthand proptype
   * PHP7.4

## Usage

PropTypes was originally exposed as part of the React core module, and is commonly used with React components. We've tried to bring the familiarity of React PropTypes into PHP. Here is an example of using PropTypes with a PHP function, which also documents the different validators provided.

You can call `PropTypes::check()` to validate an array of props, providing it with a props spec as below:

```php
use Guym4c\PropTypes\Exception\PropTypeException;
use Guym4c\PropTypes\PropTypes;

[
    // You can declare that a prop has a specific type.
    // By default, these are all optional.
    'optionalArray' => PropTypes::array(),
    'optionalBool' => PropTypes::bool(),
    'optionalFunction' => PropTypes::callable(),
    'optionalInteger' => PropTypes::int(),
    'optionalFloat' => PropTypes::float(),
    'optionalIterable' => PropTypes::iterable(),
    'optionalObject' => PropTypes::object(),
    'optionalString' => PropTypes::string(),
    // You can also declare that a prop is an instance of a class.
    // This uses `instanceof` operator.
    'optionalDateTime' => PropTypes::instanceOf(DateTime::class),
    // You can ensure that your prop is limited to specific values
    // by treating it as an enum.
    'optionalEnum' => PropTypes::oneOf(['News', 'Photos']),
    // An object that could be one of many types
    'optionalUnion' => PropTypes::oneOfType([
        PropTypes::string(),
        PropTypes::int(),
        PropTypes::instanceOf(DateTime::class),
    ]),

    // Float or int shorthand
    'optionalNumber' => PropTypes::number(),

    // An array of a certain type
    'optionalArrayOf' => PropTypes::arrayOf(PropTypes::int()),

    // You can chain any of the above with `isRequired`
    // to make sure an error is thrown if the prop isn't provided.

    // An object taking on a particular shape
    'optionalArrayWithShape' => PropTypes::shape([
        'optionalProperty' => PropTypes::string(),
        'requiredProperty' => PropTypes::int()->isRequired(),
    ]),

    // An object with errors on extra properties
    'optionalObjectWithStrictShape' => PropTypes::exact([
        'optionalProperty' => PropTypes::string(),
        'requiredProperty' => PropTypes::int()->isRequired(),
    ]),

    // A value of any data type (except null)
    'requiredAny' => PropTypes::any()->isRequired(),
    // A value of any data type (including null)
    'requiredNullableAny' => PropTypes::any()->isRequired()->isNullable(),

    // A required property that can be string or null
    'requiredNullableString' => PropTypes::string()->isRequired()->isNullable(),

    // You can also specify a custom validator.
    // It should return a PropTypeException instance if the validation fails.
    'customProp' => PropTypes::callback(
        function (array $props, string $prop_name, string $prop_full_name): ?PropTypeException {
            if (! preg_match('/matchme /', $props[$prop_name])) {
                return new PropTypeException(
                    $prop_name,
                    'Invalid prop `' . $prop_full_name . '` supplied. Validation failed.'
                );
            }
            return null;
        }
    ),
];
```

## Difference from React PropTypes

1. In this package we've split *required* and *nullable* checks into different traits:
   - *Required* means a property has to be defined in the props object
   - *Nullable* means a property value can be set to `null`  
   
   React PropTypes has less straightforward logic around required, nulls and undefined.
   
2. As opposed to React PropTypes we don't have a separate checker for null (`PropTypes::null()`).
   Instead any property can become nullable by calling `->isNullable()` on its checker:
   
   ```php
   [
      'title' => PropTypes::string()->isNullable(),
   ];
   ```
