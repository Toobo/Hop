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
 * @param callable(mixed):bool $callable
 * @return callable(mixed):bool
 */
function not(callable $callable): callable
{
    return static function (mixed $value) use ($callable): bool {
        return !$callable($value);
    };
}

/**
 * @param callable(mixed):bool $first
 * @param callable(mixed):bool $second
 * @param list<callable(mixed):bool> $callbacks
 * @return callable(mixed):bool
 */
function chain(callable $first, callable $second, callable ...$callbacks): callable
{
    array_unshift($callbacks, $second);
    array_unshift($callbacks, $first);

    return static function (mixed $value) use ($callbacks): bool {
        foreach ($callbacks as $callable) {
            if (!$callable($value)) {
                return false;
            }
        }

        return true;
    };
}

/**
 * @param callable(mixed):bool $first
 * @param callable(mixed):bool $second
 * @param list<callable(mixed):bool> $callbacks
 * @return callable(mixed):bool
 */
function pool(callable $first, callable $second, callable ...$callbacks): callable
{
    array_unshift($callbacks, $second);
    array_unshift($callbacks, $first);

    return static function (mixed $value) use ($callbacks): bool {
        foreach ($callbacks as $callable) {
            if ($callable($value)) {
                return true;
            }
        }

        return false;
    };
}
