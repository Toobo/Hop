<?php
/*
 * This file is part of the toobo/hop package.
 *
 * (c) Giuseppe Mazzapica <giuseppe.mazzapica@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Toobo\Hop;

use function Toobo\Hop\Utils\assertNumeric;

/**
 * @param mixed $compare
 * @return callable
 */
function is($compare): callable
{
    return function ($value) use ($compare): bool {
        return $value === $compare;
    };
}

/**
 * @param mixed $compare
 * @return \callable
 */
function isNot($compare): callable
{
    return function ($value) use ($compare): bool {
        return $value !== $compare;
    };
}

/**
 * @param $compare
 * @return callable
 */
function equals($compare): callable
{
    return function ($value) use ($compare): bool {
        return $value == $compare; // phpcs:ignore
    };
}

/**
 * @param $compare
 * @return callable
 */
function notEquals($compare): callable
{
    return function ($value) use ($compare): bool {
        return $value != $compare; // phpcs:ignore
    };
}

/**
 * @param string $regex
 * @return callable
 */
function match(string $regex): callable
{
    if (!$regex) {
        return never();
    }

    return function (string $value) use ($regex): bool {
        return @preg_match($regex, $value) > 0;
    };
}

/**
 * @param string $regex
 * @return callable
 */
function notMatch(string $regex): callable
{
    if (!$regex) {
        return always();
    }

    return function (string $value) use ($regex): bool {
        return @preg_match($regex, $value) === 0;
    };
}

/**
 * @param int|float $limit
 * @return callable
 */
function moreThan($limit): callable
{
    assertNumeric($limit, 'Toobo\Hop\moreThan');

    return function ($value) use ($limit): bool {
        assertNumeric($value, 'predicate returned by  Toobo\Hop\moreThan');

        return $value > $limit;
    };
}

/**
 * @param int|float $limit
 * @return callable
 */
function moreThanOrEqual($limit): callable
{
    assertNumeric($limit, 'Toobo\Hop\moreThanOrEqual');

    return function ($value) use ($limit): bool {
        assertNumeric($value, 'predicate returned by  Toobo\Hop\moreThanOrEqual');

        return $value >= $limit;
    };
}

/**
 * @param int|float $limit
 * @return callable
 */
function lessThan($limit): callable
{
    assertNumeric($limit, 'Toobo\Hop\lessThan');

    return function ($value) use ($limit): bool {
        assertNumeric($value, 'predicate returned by Toobo\Hop\lessThan');

        return $value < $limit;
    };
}

/**
 * @param int|float $limit
 * @return callable
 */
function lessThanOrEqual($limit): callable
{
    assertNumeric($limit, 'Toobo\Hop\lessThanOrEqual');

    return function ($value) use ($limit): bool {
        assertNumeric($value, 'predicate returned by Toobo\Hop\lessThanOrEqual');

        return $value <= $limit;
    };
}

/**
 * @param int $min
 * @param int $max
 * @return callable
 */
function between(int $min, int $max): callable
{
    return chain(moreThanOrEqual($min), lessThanOrEqual($max));
}

/**
 * @param int $min
 * @param int $max
 * @return callable
 */
function betweenInner(int $min, int $max): callable
{
    return chain(moreThan($min), lessThan($max));
}

/**
 * @param int $min
 * @param int $max
 * @return callable
 */
function betweenLeft(int $min, int $max): callable
{
    return chain(moreThanOrEqual($min), lessThan($max));
}

/**
 * @param int $min
 * @param int $max
 * @return callable
 */
function betweenRight(int $min, int $max): callable
{
    return chain(moreThan($min), lessThanOrEqual($max));
}
