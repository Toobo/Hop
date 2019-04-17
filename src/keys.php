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
 * @return callable
 */
function hasKey(string $key): callable
{
    return function (array $value) use ($key): bool {
        return array_key_exists($key, $value);
    };
}

/**
 * @param string $key
 * @return callable
 */
function hasNotKey(string $key): callable
{
    return function (array $value) use ($key): bool {
        return !array_key_exists($key, $value);
    };
}

/**
 * @param string[] $keys
 * @return callable
 *
 * phpcs:disable Generic.Metrics.NestingLevel
 */
function hasAllKeys(string ...$keys): callable
{
    // phpcs:enable Generic.Metrics.NestingLevel

    return function (array $value) use ($keys): bool {
        foreach ($keys as $key) {
            if (!array_key_exists($key, $value)) {
                return false;
            }
        }

        return true;
    };
}

/**
 * @param string[] $keys
 * @return callable
 *
 * phpcs:disable Generic.Metrics.NestingLevel
 */
function hasAnyOfKeys(string ...$keys): callable
{
    // phpcs:enable Generic.Metrics.NestingLevel

    return function (array $value) use ($keys): bool {
        foreach ($keys as $key) {
            if (array_key_exists($key, $value)) {
                return true;
            }
        }

        return false;
    };
}

/**
 * @param string[] $keys
 * @return callable
 *
 * phpcs:disable Generic.Metrics.NestingLevel
 */
function hasNoneOfKeys(string ...$keys): callable
{
    // phpcs:enable Generic.Metrics.NestingLevel

    return function (array $value) use ($keys): bool {
        foreach ($keys as $key) {
            if (array_key_exists($key, $value)) {
                return false;
            }
        }

        return true;
    };
}

/**
 * @param string[] $keys
 * @return \Closure
 *
 * phpcs:disable Generic.Metrics.NestingLevel
 */
function hasNotAllKeys(string ...$keys): callable
{
    // phpcs:enable Generic.Metrics.NestingLevel

    return function (array $value) use ($keys): bool {
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
 * @param $value
 * @return callable
 */
function valueForKeyIs(string $key, $value): callable
{
    return function (array $array) use ($key, $value): bool {

        return array_key_exists($key, $array) && $array[$key] === $value;
    };
}
/**
 * @param string $key
 * @param $item
 * @return callable
 */
function valueForKeyIsNot(string $key, $item): callable
{
    return function (array $value) use ($key, $item): bool {

        return !array_key_exists($key, $value) || $value[$key] !== $item;
    };
}

/**
 * @param string   $key
 * @param callable $callback
 * @return callable
 */
function applyOnValueForKey(string $key, callable $callback): callable
{
    return function (array $value) use ($key, $callback): bool {
        if (!array_key_exists($key, $value)) {
            return false;
        }

        return (bool)$callback($value[$key]);
    };
}
