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
 * @param int $filter
 * @param array|int $options
 * @return callable(mixed):bool
 */
function filterVar(int $filter, array|int $options = FILTER_UNSAFE_RAW): callable
{
    return static function (mixed $value) use ($filter, $options): bool {
        return (bool)filter_var($value, $filter, $options);
    };
}

/**
 * @return callable(string):bool
 */
function isEmail(): callable
{
    return static function (string $value): bool {
        return (bool)filter_var($value, FILTER_VALIDATE_EMAIL);
    };
}

/**
 * @return callable(string):bool
 */
function isUrl(): callable
{
    return static function (string $value): bool {
        // FILTER_VALIDATE_URL does not recognize protocol-relative urls
        str_starts_with($value, '//') and $value = "http:{$value}";

        return (bool)filter_var($value, FILTER_VALIDATE_URL);
    };
}

/**
 * @return callable(string):bool
 */
function isIp(): callable
{
    return static function (string $value): bool {
        return (bool)filter_var($value, FILTER_VALIDATE_IP);
    };
}

/**
 * @return callable(string):bool
 */
function isMac(): callable
{
    return static function (string $value): bool {
        return (bool)filter_var($value, FILTER_VALIDATE_MAC);
    };
}
