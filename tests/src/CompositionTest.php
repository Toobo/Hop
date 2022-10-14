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

class CompositionTest extends TestCase
{
    /**
     * @test
     */
    public function testNegateStringCallback(): void
    {
        $notString = _\not('is_string');

        static::assertTrue($notString(1));
        static::assertTrue($notString(['']));
        static::assertTrue($notString([]));
        static::assertFalse($notString(''));
        static::assertFalse($notString('x'));
    }

    /**
     * @test
     */
    public function testNegateMethodCallback(): void
    {
        $obj = new class {
            public function isYes(string $what): bool
            {
                return $what === 'yes';
            }
        };

        $notYes = _\not([$obj, 'isYes']);

        static::assertTrue($notYes(''));
        static::assertTrue($notYes('y'));
        static::assertFalse($notYes('yes'));
    }

    /**
     * @test
     */
    public function testChain(): void
    {
        $notA = static function (string $str): bool {
            return $str !== 'a';
        };

        $notB = static function (string $str): bool {
            return $str !== 'b';
        };

        $notC = static function (string $str): bool {
            return $str !== 'c';
        };

        $chain = _\chain($notA, $notB, $notC);

        static::assertTrue($chain('d'));
        static::assertTrue($chain('1'));
        static::assertFalse($chain('a'));
        static::assertFalse($chain('b'));
        static::assertFalse($chain('c'));
    }

    /**
     * @test
     */
    public function testPool(): void
    {
        $isA = static function (string $str): bool {
            return $str === 'a';
        };

        $isB = static function (string $str): bool {
            return $str === 'b';
        };

        $isC = static function (string $str): bool {
            return $str === 'c';
        };

        $pool = _\pool($isA, $isB, $isC);

        static::assertFalse($pool('d'));
        static::assertFalse($pool('1'));
        static::assertFalse($pool(''));
        static::assertTrue($pool('a'));
        static::assertTrue($pool('b'));
        static::assertTrue($pool('c'));
    }
}
