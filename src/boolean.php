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
 * @return callable():bool
 */
function always(): callable
{
    return static function (): bool {
        return true;
    };
}

/**
 * @return callable():bool
 */
function never(): callable
{
    return static function (): bool {
        return false;
    };
}

/**
 * @return callable(mixed):bool
 */
function isEmpty(): callable
{
    return static function (mixed $value): bool {
        return !$value && $value !== '0';
    };
}

/**
 * @return callable(mixed):bool
 */
function isNotEmpty(): callable
{
    return static function (mixed $value): bool {
        return $value || $value === '0';
    };
}

/**
 * @return callable(mixed):bool
 */
function isTrueish(): callable
{
    return static function (mixed $value): bool {
        return filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) ?? false;
    };
}

/**
 * @return callable(mixed):bool
 */
function isFalsey(): callable
{
    return static function (mixed $value): bool {
        return ($value !== null)
            && (filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) === false);
    };
}

/**
 * @return callable(mixed):bool
 */
function isBooleanLooking(): callable
{
    return static function (mixed $value): bool {
        return ($value !== null)
            && filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) !== null;
    };
}
