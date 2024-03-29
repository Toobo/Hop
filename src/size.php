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
 * @param int $size
 * @return callable(mixed):bool
 */
function size(int $size): callable
{
    return static function (mixed $value) use ($size): bool {
        return Utils\measure($value, 'Toobo\Hop\size') === $size;
    };
}

/**
 * @param int $max
 * @return callable(mixed):bool
 */
function smallerThan(int $max): callable
{
    return static function (mixed $value) use ($max): bool {
        return Utils\measure($value, 'Toobo\Hop\smallerThan') < $max;
    };
}

/**
 * @param int $max
 * @return callable(mixed):bool
 */
function smallerThanOrEqual(int $max): callable
{
    return static function (mixed $value) use ($max): bool {
        return Utils\measure($value, 'Toobo\Hop\smallerThanOrEqual') <= $max;
    };
}

/**
 * @param int $min
 * @return callable(mixed):bool
 */
function biggerThan(int $min): callable
{
    return static function (mixed $value) use ($min): bool {
        return Utils\measure($value, 'Toobo\Hop\biggerThan') > $min;
    };
}

/**
 * @param int $min
 * @return callable(mixed):bool
 */
function biggerThanOrEqual(int $min): callable
{
    return static function (mixed $value) use ($min): bool {
        return Utils\measure($value, 'Toobo\Hop\biggerThanOrEqual') >= $min;
    };
}

/**
 * @param int $min
 * @param int $max
 * @return callable(mixed):bool
 */
function sizeBetween(int $min, int $max): callable
{
    return chain(biggerThanOrEqual($min), smallerThanOrEqual($max));
}

/**
 * @param int $min
 * @param int $max
 * @return callable(mixed):bool
 */
function sizeBetweenInner(int $min, int $max): callable
{
    return chain(biggerThan($min), smallerThan($max));
}

/**
 * @param int $min
 * @param int $max
 * @return callable(mixed):bool
 */
function sizeBetweenLeft(int $min, int $max): callable
{
    return chain(biggerThanOrEqual($min), smallerThan($max));
}

/**
 * @param int $min
 * @param int $max
 * @return callable(mixed):bool
 */
function sizeBetweenRight(int $min, int $max): callable
{
    return chain(biggerThan($min), smallerThanOrEqual($max));
}
