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
 * @param string $type
 * @return callable(mixed):bool
 *
 * phpcs:disable Generic.Metrics.CyclomaticComplexity
 */
function isType(string $type): callable
{
    // phpcs:enable Generic.Metrics.CyclomaticComplexity
    return static function (mixed $value) use ($type): bool {
        /** @psalm-suppress ArgumentTypeCoercion */
        return match ($type) {
            \Hop\T_STRING => is_string($value),
            \Hop\T_BOOL, \Hop\T_BOOLEAN => is_bool($value),
            \Hop\T_INT, \Hop\T_INTEGER => is_int($value),
            \Hop\T_DOUBLE, \Hop\T_FLOAT => is_float($value),
            \Hop\T_NUMBER, \Hop\T_NUMERIC => is_numeric($value),
            \Hop\T_RESOURCE => is_resource($value),
            \Hop\T_ARRAY => is_array($value),
            \Hop\T_ARRAY_LIKE => is_array($value) || $value instanceof \ArrayObject,
            \Hop\T_OBJECT => is_object($value),
            \Hop\T_ITERABLE, \Hop\T_TRAVERSABLE => is_iterable($value),
            \Hop\T_NULL, \Hop\T_VOID => $value === null,
            default => is_a($value, $type, true),
        };
    };
}

/**
 * @param class-string $classOrInterface
 * @return callable(object):bool
 */
function objectIs(string $classOrInterface): callable
{
    return static function (object $value) use ($classOrInterface): bool {
        return is_a($value, $classOrInterface, false);
    };
}
