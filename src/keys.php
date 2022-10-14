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
 * @param string $key
 * @return callable(array):bool
 */
function hasKey(string $key): callable
{
    return static function (array $value) use ($key): bool {
        return array_key_exists($key, $value);
    };
}

/**
 * @param string $key
 * @return callable(array):bool
 */
function hasNotKey(string $key): callable
{
    return static function (array $value) use ($key): bool {
        return !array_key_exists($key, $value);
    };
}

/**
 * @param list<string> $keys
 * @return callable(array):bool
 */
function hasAllKeys(string ...$keys): callable
{
    return static function (array $value) use ($keys): bool {
        foreach ($keys as $key) {
            if (!array_key_exists($key, $value)) {
                return false;
            }
        }

        return true;
    };
}

/**
 * @param list<string> $keys
 * @return callable(array):bool
 */
function hasAnyOfKeys(string ...$keys): callable
{
    return static function (array $value) use ($keys): bool {
        foreach ($keys as $key) {
            if (array_key_exists($key, $value)) {
                return true;
            }
        }

        return false;
    };
}

/**
 * @param list<string> $keys
 * @return callable(array):bool
 */
function hasNoneOfKeys(string ...$keys): callable
{
    return static function (array $value) use ($keys): bool {
        foreach ($keys as $key) {
            if (array_key_exists($key, $value)) {
                return false;
            }
        }

        return true;
    };
}

/**
 * @param list<string> $keys
 * @return callable(array):bool
 */
function hasNotAllKeys(string ...$keys): callable
{
    return static function (array $value) use ($keys): bool {
        foreach ($keys as $key) {
            if (!array_key_exists($key, $value)) {
                return true;
            }
        }

        return false;
    };
}

/**
 * @param string $key
 * @param mixed $value
 * @return callable(array):bool
 */
function valueForKeyIs(string $key, mixed $value): callable
{
    return static function (array $array) use ($key, $value): bool {
        return array_key_exists($key, $array) && $array[$key] === $value;
    };
}
/**
 * @param string $key
 * @param mixed $item
 * @return callable(array):bool
 */
function valueForKeyIsNot(string $key, mixed $item): callable
{
    return static function (array $value) use ($key, $item): bool {
        return !array_key_exists($key, $value) || $value[$key] !== $item;
    };
}

/**
 * @param string $key
 * @param callable $callback
 * @return callable(array):bool
 */
function applyOnValueForKey(string $key, callable $callback): callable
{
    return static function (array $value) use ($key, $callback): bool {
        if (!array_key_exists($key, $value)) {
            return false;
        }

        return (bool)$callback($value[$key]);
    };
}
