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

class IteratedTest extends TestCase
{
    public function testIterateAndVerifyAll()
    {
        $cb = _\iterateAndVerifyAll(function (int $val): bool {
            return ($val / 2) % 2 === 0;
        });

        $ok = function (): \Generator {
            yield 4;
            yield 8;
            yield 16;
            yield 32;
        };

        $no = function (): \Generator {
            yield 4;
            yield 6;
        };

        static::assertTrue($cb($ok()));
        static::assertFalse($cb($no()));
    }

    public function testIterateAndVerifyAny()
    {
        $cb = _\iterateAndVerifyAny(function (int $val): bool {
            return ($val / 2) % 2 === 0;
        });

        $ok = function (): \Generator {
            yield 2;
            yield 6;
            yield 12;
            yield 14;
        };

        $no = function (): \Generator {
            yield 2;
            yield 6;
            yield 10;
            yield 14;
        };

        static::assertTrue($cb($ok()));
        static::assertFalse($cb($no()));
    }
}
