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
 * @return callable
 */
function filterVar(int $filter, $options = null): callable
{
    return function ($value) use ($filter, $options): bool {
        return (bool)filter_var($value, $filter, $options);
    };
}

/**
 * @return callable
 */
function isEmail(): callable
{
    return function ($value): bool {
        return (bool)filter_var($value, FILTER_VALIDATE_EMAIL);
    };
}

/**
 * @return callable
 */
function isUrl(): callable
{
    return function (string $value): bool {
        // FILTER_VALIDATE_URL does not recognize protocol-relative urls
        if (strpos($value, '//') === 0) {
            $value = "http:{$value}";
        }

        return (bool)filter_var($value, FILTER_VALIDATE_URL);
    };
}

/**
 * @return callable
 */
function isIp(): callable
{
    return function ($value): bool {
        return (bool)filter_var($value, FILTER_VALIDATE_IP);
    };
}

/**
 * @return callable
 */
function isMac(): callable
{
    return function ($value): bool {
        return (bool)filter_var($value, FILTER_VALIDATE_MAC);
    };
}
