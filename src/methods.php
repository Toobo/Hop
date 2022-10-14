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
 * @param string $method
 * @return callable(object):bool
 */
function hasMethod(string $method): callable
{
    return static function (object $object) use ($method): bool {
        return method_exists($object, $method);
    };
}

/**
 * @param string $method
 * @return callable(class-string):bool
 */
function classHasMethod(string $method): callable
{
    return static function (string $class) use ($method): bool {
        return method_exists($class, $method);
    };
}

/**
 * @param string $method
 * @param mixed $value
 * @param mixed ...$params
 * @return callable(object):bool
 */
function methodReturns(string $method, mixed $value, mixed ...$params): callable
{
    return static function (object $object) use ($method, $value, $params): bool {
        /** @psalm-suppress MixedMethodCall */
        return $object->{$method}(...$params) === $value;
    };
}
