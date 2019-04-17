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
 * @param callable $callable
 * @return callable
 */
function not(callable $callable): callable
{
    return function ($value) use ($callable): bool {
        return !$callable($value);
    };
}

/**
 * @param callable $first
 * @param callable $second
 * @param callable[] $callbacks
 * @return callable
 *
 * phpcs:disable Generic.Metrics.NestingLevel
 */
function chain(callable $first, callable $second, callable ...$callbacks): callable
{
    // phpcs:enable Generic.Metrics.NestingLevel

    array_unshift($callbacks, $second);
    array_unshift($callbacks, $first);

    return function ($value) use ($callbacks): bool {
        /** @var callable $callable */
        foreach ($callbacks as $callable) {
            if (!$callable($value)) {
                return false;
            }
        }

        return true;
    };
}

/**
 * @param callable $first
 * @param callable $second
 * @param callable[] $callbacks
 * @return callable
 *
 * phpcs:disable Generic.Metrics.NestingLevel
 */
function pool(callable $first, callable $second, callable ...$callbacks): callable
{
    // phpcs:enable Generic.Metrics.NestingLevel

    array_unshift($callbacks, $second);
    array_unshift($callbacks, $first);

    return function ($value) use ($callbacks): bool {
        foreach ($callbacks as $callable) {
            if ($callable($value)) {
                return true;
            }
        }

        return false;
    };
}
