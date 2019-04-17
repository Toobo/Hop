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
 * @return callable
 */
function hasMethod(string $method): callable
{
    return function (object $object) use ($method) : bool {
        return method_exists($object, $method);
    };
}

/**
 * @param string $method
 * @return callable
 */
function classHasMethod(string $method): callable
{
    return function (string $class) use ($method) : bool {
        return method_exists($class, $method);
    };
}

/**
 * @param string $method
 * @param mixed $value
 * @param mixed ...$params
 * @return callable
 */
function methodReturns(string $method, $value, ...$params): callable
{
    return function (object $object) use ($method, $value, $params): bool {
        return $object->{$method}(...$params) === $value;
    };
}
