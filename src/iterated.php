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
 * @return callable(iterable):bool
 */
function iterateAndVerifyAll(callable $callable): callable
{
    return static function (iterable $value) use ($callable): bool {
        /** @var mixed $item */
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
 * @return callable(iterable):bool
 */
function iterateAndVerifyAny(callable $callable): callable
{
    return static function (iterable $value) use ($callable): bool {
        /** @var mixed $item */
        foreach ($value as $item) {
            if ($callable($item)) {
                return true;
            }
        }

        return false;
    };
}
