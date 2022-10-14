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
 * Returns a function which applies a transformation function to its input before testing it
 * with the predicate function.
 *
 * @param  callable $transformation
 * @param  callable $predicate
 * @return callable(mixed):bool
 */
function applyAfter(callable $transformation, callable $predicate): callable
{
    return static function (mixed $value) use ($transformation, $predicate): bool {
        return (bool)$predicate($transformation($value));
    };
}

/**
 * Returns a function which applies the result of given predicate, applied to the result of the
 * given method call, on the object that will be passed as parameter.
 *
 * @param string $method
 * @param callable $predicate
 * @param mixed ...$params
 * @return callable(object):bool
 */
function applyAfterMethod(string $method, callable $predicate, mixed ...$params): callable
{
    return static function (object $object) use ($method, $predicate, $params): bool {
        /** @psalm-suppress MixedMethodCall */
        return (bool)$predicate($object->{$method}(...$params));
    };
}
