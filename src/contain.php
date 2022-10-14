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
 * @return callable(string):bool
 */
function contains(string $subString): callable
{
    return static function (string $value) use ($subString): bool {
        return Utils\strPos($value, $subString) !== -1;
    };
}

/**
 * @param string $start
 * @return callable(string):bool
 */
function startsWith(string $start): callable
{
    return static function (string $value) use ($start): bool {
        $len = Utils\measure($start, 'the predicate returned by Toobo\Hop\startsWith');

        return Utils\subStr($value, 0, $len) === $start;
    };
}

/**
 * @param string $end
 * @return callable(string):bool
 */
function endsWith(string $end): callable
{
    return static function (string $value) use ($end): bool {
        $len = Utils\measure($end, 'the predicate returned by Toobo\Hop\endsWith');

        return Utils\subStr($value, -1 * $len) === $end;
    };
}

/**
 * @param mixed $item
 * @return callable(array):bool
 */
function has(mixed $item): callable
{
    return static function (array $value) use ($item): bool {
        return in_array($item, $value, true);
    };
}

/**
 * @param mixed $item
 * @param mixed ...$items
 * @return callable(array):bool
 */
function headIs(mixed $item, mixed ...$items): callable
{
    array_unshift($items, $item);

    return static function (array $value) use ($items): bool {
        $i = 0;
        $total = count($items);
        /** @var mixed $item */
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
 * @param mixed $item
 * @param mixed ...$items
 * @return callable(array):bool
 */
function tailIs(mixed $item, mixed ...$items): callable
{
    array_unshift($items, $item);

    return static function (array $value) use ($items): bool {
        $itemsCount = count($items);
        $compare = array_slice($value, -1 * $itemsCount, $itemsCount);
        $i = 0;
        /** @var mixed $item */
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
 * @param mixed $item
 * @param array $items
 * @return callable(mixed):bool
 */
function in(mixed $item, mixed ...$items): callable
{
    array_unshift($items, $item);

    return static function (mixed $value) use ($items): bool {
        return in_array($value, $items, true);
    };
}

/**
 * @param mixed $item
 * @param array $items
 * @return callable(mixed):bool
 */
function notIn(mixed $item, mixed ...$items): callable
{
    array_unshift($items, $item);

    return static function (mixed $value) use ($items): bool {
        return !in_array($value, $items, true);
    };
}

/**
 * @param array $items
 * @return callable(array):bool
 */
function intersect(mixed ...$items): callable
{
    return static function (array $value) use ($items): bool {
        return (bool)array_intersect($items, $value);
    };
}

/**
 * @param array $items
 * @return callable(array):bool
 */
function notIntersect(mixed ...$items): callable
{
    return static function (array $value) use ($items): bool {
        return !array_intersect($items, $value);
    };
}
