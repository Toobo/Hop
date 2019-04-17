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
 * @param string $subString
 * @return callable
 */
function contains(string $subString): callable
{
    return function (string $value) use ($subString): bool {
        return Utils\strPos($value, $subString) !== -1;
    };
}

/**
 * @param string $start
 * @return callable
 */
function startsWith(string $start): callable
{
    return function (string $value) use ($start): bool {
        $len = Utils\measure($start, 'the predicate returned by Toobo\Hop\startsWith');

        return Utils\subStr($value, 0, $len) === $start;
    };
}

/**
 * @param string $end
 * @return callable
 */
function endsWith(string $end): callable
{
    return function (string $value) use ($end): bool {
        $len = Utils\measure($end, 'the predicate returned by Toobo\Hop\endsWith');

        return Utils\subStr($value, -1 * $len) === $end;
    };
}

/**
 * @param $item
 * @return callable
 */
function has($item): callable
{
    return function (array $value) use ($item): bool {
        return in_array($item, $value, true);
    };
}

/**
 * @param $item
 * @param mixed ...$items
 * @return callable
 *
 * phpcs:disable Generic.Metrics.NestingLevel
 */
function headIs($item, ...$items): callable
{
    // phpcs:enable Generic.Metrics.NestingLevel

    array_unshift($items, $item);

    return function (array $value) use ($items): bool {
        $i = 0;
        $total = count($items);
        foreach ($value as $item) {
            if ($items[$i] !== $item) {
                return false;
            }
            $i++;
            if ($i === $total) {
                return true;
            }
        }

        return false;
    };
}

/**
 * @param $item
 * @param mixed ...$items
 * @return callable
 *
 * phpcs:disable Generic.Metrics.NestingLevel
 */
function tailIs($item, ...$items): callable
{
    // phpcs:enable Generic.Metrics.NestingLevel

    array_unshift($items, $item);

    return function (array $value) use ($items): bool {
        $itemsCount = count($items);
        $compare = array_slice($value, -1 * $itemsCount, $itemsCount);
        $i = 0;
        foreach ($compare as $item) {
            if ($items[$i] !== $item) {
                return false;
            }
            $i++;
            if ($i === $itemsCount) {
                return true;
            }
        }

        return array_values($compare) === $items;
    };
}

/**
 * @param $item
 * @param array $items
 * @return callable
 */
function in($item, ...$items): callable
{
    array_unshift($items, $item);

    return function ($value) use ($items): bool {
        return in_array($value, $items, true);
    };
}

/**
 * @param $item
 * @param array $items
 * @return callable
 */
function notIn($item, ...$items): callable
{
    array_unshift($items, $item);

    return function ($value) use ($items): bool {
        return !in_array($value, $items, true);
    };
}

/**
 * @param array $items
 * @return callable
 */
function intersect(...$items): callable
{
    return function (array $value) use ($items): bool {
        return (bool)array_intersect($items, $value);
    };
}

/**
 * @param array $items
 * @return callable
 */
function notIntersect(...$items): callable
{
    return function (array $value) use ($items): bool {
        return !array_intersect($items, $value);
    };
}
