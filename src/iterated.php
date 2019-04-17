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
 *
 * phpcs:disable Generic.Metrics.NestingLevel
 */
function iterateAndVerifyAll(callable $callable): callable
{
    // phpcs:enable Generic.Metrics.NestingLevel

    return function (iterable $value) use ($callable): bool {
        foreach ($value as $item) {
            if (!$callable($item)) {
                return false;
            }
        }

        return true;
    };
}

/**
 * @param callable $callable
 * @return \Closure
 *
 * phpcs:disable Generic.Metrics.NestingLevel
 */
function iterateAndVerifyAny(callable $callable): callable
{
    // phpcs:enable Generic.Metrics.NestingLevel

    return function (iterable $value) use ($callable): bool {
        foreach ($value as $item) {
            if ($callable($item)) {
                return true;
            }
        }

        return false;
    };
}
