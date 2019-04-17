Hop
=========

----------------------------------

> Higher order predicates library.

----------------------------------

# What?

An "higher order function" is a function that either returns a function or takes a function as argument.

A "functional predicate" is a function that receives one or more arguments (subject) and returns `true` or `false`.

**This library is a collections of functions that return functional predicates**.

# Why?

In PHP there are some functions like `array_map`, `array_filter`, and so on, that take a functional predicate
as argument.

For example:

```php
$data = [
  'foo',
  1,
  true,
  'bar',
  [],
  ''
];

$strings = array_filter($data, 'is_string'); // ['foo', 'bar', '']
```

This can be done thanks to the fact that a `is_string` is a named function.

But if we need something more complex, e.g. we also want to strip empty strings, we need to:

```php
$strings = array_filter($data, function($item) {
    return is_string($item) && $item !== '';
});
```

One of the functions of this library is `isType()` that accepts a string representing a type 
and returns a predicate that can be used to check subjects against that typoe.

Another of the functions of this library is `isNotEmpty()` that returns a predicate that verifies non-empty values.

Another function is `combine()` that takes an arbitrary number of predicates and returns a predicate
that returns `true` when all the combined predicates return true.

Using these 3 functions the code above can be written like this:

```php
use Hop as P;

$strings = array_filter($data, P\chain(P\isType('string'), P\isNotEmpty()));
```

All the functions in this library are in `Hop` namespace.


# Installation

Served by Composer using `gmazzap/Hop`.


# List of functions

Here a list of all the functions currently provided by library (namespace omitted):

### General

 - `always()` Return a predicate that always return `true`
 - `never()` Return a predicate that always return `false`
 - `isEmpty()`
 - `isNotEmpty()`
 - `isTrueish()`
 - `isFalsey()`
 - `isBooleanLooking()`
 
### Comparison
 
 - `is($value)`
 - `isNot($value)`
 - `equals($value)`
 - `notEquals($value)`
 - `match(string $regex)` 
 - `notMatch(string $regex)`
 - `moreThan(int|float $limit)`
 - `moreThanOrEqual(int|float $limit)`
 - `lessThan(int|float $limit)`
 - `lessThanOrEqual(int|float $limit)`
 - `between(int|float $min, int|float $max)`
 - `betweenInner(int|float $min, int|float $max)`
 - `betweenLeft(int|float $min, int|float $max)`
 - `betweenRight(int|float $min, int|float $max)`
 
### Type check

 - `isType(string $type)` Works with scalar types, classes and interfaces
 - `objectIs(string $classOrInterface)` Works with objects

### Var filtering check

 - `filterVar(int $filter, $options = null)` Returns a predicate that applies `filter_var()` to subject using given filter and options.
 - `isEmail()`
 - `isUrl()`
 - `isIp()`
 - `isMac()`
 
### Size check

 - `size(int $size)` Verify elements count of arrays and countable objects and string length
 - `smallerThan(int $size)`
 - `smallerThanOrEqual(int $size)`
 - `biggerThan(int $size)`
 - `biggerThanOrEqual(int $size)`
 - `sizeBetween(int $min, int $max)`
 - `sizeBetweenInner(int $min, int $max)`
 - `sizeBetweenLeft(int $min, int $max)`
 - `sizeBetweenRight(int $min, int $max)`
 
### Elements check (for arrays and strings)

 - `contains(string $subString)` Verify a string contains a sub-string
 - `startsWith(string $subString)` Verify a string starts with a sub-string
 - `endsWith(string $subString)` Verify a string ends with a sub-string
 - `has($item)` Verify an string contains an item
 - `headIs(...$items)` Verify first item(s) of an array
 - `tailIs(...$items)` Verify last item(s) of an array
 - `in(...$items)` Verify an item is one of given items
 - `notIn(...$items)` Verify an item is none of given items
 - `intersect(...$items)` Verify an array has an non-empty intersection with given items
 - `notIntersect(...$items)` Verify an array has an empty intersection with given items
 
### Array keys

 - `hasKey(string $key)`
 - `hasNotKey(string $key)`
 - `hasAllKeys(string ...$keys)`
 - `hasAnyOfKeys(string ...$keys)`
 - `hasNoneOfKeys(string ...$keys)`
 - `hasNotAllKeys(string ...$keys)`
 - `valueForKeyIs(string $key, $value)`
 - `valueForKeyIsNot(string $key, $value)`
 - `applyOnValueForKey(string $key, callable $callback)`
 
### Object methods

 - `hasMethod(string $method)`
 - `classHasMethod(string $method)`
 - `methodReturns(string $method, $value, ...$params)`
 
### Predicates composition

- `not(callable $predicate)` Negate given predicate
- `chain(callable ...$predicates)` Combine predicates in AND mode
- `pool(callable ...$predicates)` Combine predicates in OR mode

### Misc

- `applyAfter(callable $transformation, callable $predicate)` Returns a predicate which returns the result of the predicate, after it has been applied the input value, transformed by the `$transformation` function.
- `applyAfterMethod(string $method, callable $predicate)`
