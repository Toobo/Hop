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
 * @return callable
 */
function always(): callable
{
    return function (): bool {
        return true;
    };
}

/**
 * @return callable
 */
function never(): callable
{
    return function (): bool {
        return false;
    };
}

/**
 * @return callable
 */
function isEmpty(): callable
{
    return function ($value): bool {
        return !$value && $value !== '0';
    };
}

/**
 * @return callable
 */
function isNotEmpty(): callable
{
    return function ($value): bool {
        return $value || $value === '0';
    };
}

/**
 * @return callable
 */
function isTrueish(): callable
{
    return function ($value): bool {
        $filtered = filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);

        return $filtered ?? false;
    };
}

/**
 * @return callable
 */
function isFalsey(): callable
{
    return function ($value): bool {
        if ($value === null) {
            return false;
        }

        $filtered = filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);

        return $filtered === null ? false : !$filtered;
    };
}

/**
 * @return callable
 */
function isBooleanLooking(): callable
{
    return function ($value): bool {
        if ($value === null) {
            return false;
        }

        return filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) !== null;
    };
}
