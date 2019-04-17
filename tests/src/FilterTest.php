<?php
/*
 * This file is part of the toobo/hop.
 *
 * (c) Giuseppe Mazzapica <giuseppe.mazzapica@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Toobo\Hop\Tests;

use PHPUnit\Framework\TestCase;
use Toobo\Hop as _;

class FilterTest extends TestCase
{
    public function testFilterVarWithOptions()
    {
        $cb = _\filterVar(FILTER_CALLBACK, ['options' => function (int $value): bool {
            return $value % 2 === 0;
        }, ]);

        static::assertTrue($cb(4));
        static::assertFalse($cb(3));
    }

    public function testIsEmail()
    {
        $cb = _\isEmail();

        static::assertTrue($cb('info@example.com'));
        static::assertFalse($cb('@info@example.com'));
    }

    public function testIsUrl()
    {
        $cb = _\isUrl();

        static::assertTrue($cb('http://example.com'));
        static::assertTrue($cb('https://example.com'));
        static::assertTrue($cb('//example.com'));
        static::assertFalse($cb('example .com'));
    }

    public function testIsIp()
    {
        $cb = _\isIp();

        static::assertTrue($cb('127.0.0.1'));
        static::assertTrue($cb('151.66.127.125'));
        static::assertFalse($cb('example.com'));
    }

    public function testIsMac()
    {
        $cb = _\isMac();

        static::assertTrue($cb('1C-D3-8A-61-2F-AE'));
        static::assertTrue($cb('2E:D2:31:D9:20:47'));
        static::assertTrue($cb('6831.1C4D.E78A'));
        static::assertFalse($cb('1Z-D3-8A-61-2F-AE'));
    }
}
