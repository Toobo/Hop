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

class MiscTest extends TestCase
{
    /**
     * @test
     */
    public function testApplyAfter(): void
    {
        $cb = _\applyAfter('strrev', static function (string $str): bool {
            return str_starts_with($str, 'a');
        });

        static::assertTrue($cb('d-c-b-a'));
        static::assertFalse($cb('a-b-c-d'));
    }

    /**
     * @test
     */
    public function testApplyAfterMethod(): void
    {
        $cb = _\applyAfterMethod('getArrayCopy', static function (array $arr): bool {
            return ($arr['x'] ?? 1) === 2;
        });

        static::assertTrue($cb(new \ArrayObject(['x' => 2])));
        static::assertFalse($cb(new \ArrayObject(['x' => 3])));
    }
}
