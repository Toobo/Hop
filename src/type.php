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
 * @return callable
 *
 * phpcs:disable Generic.Metrics.CyclomaticComplexity
 * phpcs:disable Generic.Metrics.NestingLevel
 */
function isType(string $type): callable
{
    // phpcs:enable Generic.Metrics.CyclomaticComplexity
    // phpcs:enable Generic.Metrics.NestingLevel

    return function ($value) use ($type): bool {
        switch ($type) {
            case \Hop\T_STRING:
                return is_string($value);
            case \Hop\T_BOOL:
            case \Hop\T_BOOLEAN:
                return is_bool($value);
            case \Hop\T_INT:
            case \Hop\T_INTEGER:
                return is_int($value);
            case \Hop\T_DOUBLE:
            case \Hop\T_FLOAT:
                return is_float($value);
            case \Hop\T_NUMBER:
            case \Hop\T_NUMERIC:
                return is_numeric($value);
            case \Hop\T_RESOURCE:
                return is_resource($value);
            case \Hop\T_ARRAY:
                return is_array($value);
            case \Hop\T_ARRAY_LIKE:
                return is_array($value) || $value instanceof \ArrayObject;
            case \Hop\T_OBJECT:
                return is_object($value);
            case \Hop\T_ITERABLE:
            case \Hop\T_TRAVERSABLE:
                return is_iterable($value);
            case \Hop\T_NULL:
            case \Hop\T_VOID:
                return $value === null;
        }

        return is_a($value, $type, true);
    };
}

/**
 * @param string $classOrInterface
 * @return callable
 */
function objectIs(string $classOrInterface): callable
{
    return function (object $value) use ($classOrInterface): bool {
        return is_a($value, $classOrInterface, false);
    };
}
