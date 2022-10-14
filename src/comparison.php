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

/**
 * @param mixed $compare
 * @return callable(mixed):bool
 */
function is(mixed $compare): callable
{
    return static function (mixed $value) use ($compare): bool {
        return $value === $compare;
    };
}

/**
 * @param mixed $compare
 * @return callable(mixed):bool
 */
function isNot(mixed $compare): callable
{
    return static function (mixed $value) use ($compare): bool {
        return $value !== $compare;
    };
}

/**
 * @param mixed $compare
 * @return callable(mixed):bool
 */
function equals(mixed $compare): callable
{
    return static function (mixed $value) use ($compare): bool {
        return $value == $compare; // phpcs:ignore
    };
}

/**
 * @param mixed $compare
 * @return callable(mixed):bool
 */
function notEquals(mixed $compare): callable
{
    return static function (mixed $value) use ($compare): bool {
        return $value != $compare; // phpcs:ignore
    };
}

/**
 * @param string $regex
 * @return callable(string):bool
 */
function matches(string $regex): callable
{
    return static function (string $value) use ($regex): bool {
        return $regex && (@preg_match($regex, $value) > 0);
    };
}

/**
 * @param string $regex
 * @return callable(string):bool
 */
function notMatches(string $regex): callable
{
    return static function (string $value) use ($regex): bool {
        return !$regex || (@preg_match($regex, $value) === 0);
    };
}

/**
 * @param int|float $limit
 * @return callable(int|float):bool
 */
function moreThan(int|float $limit): callable
{
    return static function (int|float $value) use ($limit): bool {
        return $value > $limit;
    };
}

/**
 * @param int|float $limit
 * @return callable(int|float):bool
 */
function moreThanOrEqual(int|float $limit): callable
{
    return static function (int|float $value) use ($limit): bool {
        return $value >= $limit;
    };
}

/**
 * @param int|float $limit
 * @return callable(int|float):bool
 */
function lessThan(int|float $limit): callable
{
    return static function (int|float $value) use ($limit): bool {
        return $value < $limit;
    };
}

/**
 * @param int|float $limit
 * @return callable(int|float):bool
 */
function lessThanOrEqual(int|float $limit): callable
{
    return static function (int|float $value) use ($limit): bool {
        return $value <= $limit;
    };
}

/**
 * @param int $min
 * @param int $max
 * @return callable(int):bool
 */
function between(int $min, int $max): callable
{
    return chain(moreThanOrEqual($min), lessThanOrEqual($max));
}

/**
 * @param int $min
 * @param int $max
 * @return callable(int):bool
 */
function betweenInner(int $min, int $max): callable
{
    return chain(moreThan($min), lessThan($max));
}

/**
 * @param int $min
 * @param int $max
 * @return callable(int):bool
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
