<?php
/**
 * Numbers_Words class extension to spell numbers in Spanish (Castellano).
 *
 * PHP versions 4 and 5
 *
 * LICENSE: This source file is subject to version 3.01 of the PHP license
 * that is available through the world-wide-web at the following URI:
 * http://www.php.net/license/3_01.txt.  If you did not receive a copy of
 * the PHP License and are unable to obtain it through the web, please
 * send a note to license@php.net so we can mail you a copy immediately.
 *
 * @category   Numbers
 * @package    Numbers_Words
 * @author     Xavier Noguer <xnoguer.php@gmail.com>
 * @copyright  1997-2008 The PHP Group
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version    SVN: $Id$
 * @link       http://pear.php.net/package/Numbers_Words
 */

namespace App\Tests\Words;

use IntlNumbersToWords\Numbers;
use PHPUnit\Framework\TestCase;

/**
 * @covers \IntlNumbersToWords\Words\Es
 * @covers \IntlNumbersToWords\Words\Es\Ec
 * @covers \IntlNumbersToWords\Numbers
 */
class SpanishECTest extends TestCase
{
    protected Numbers $handle;

    protected string $locale = 'es_ec';

    public function setUp(): void
    {
        $this->handle = new Numbers();
    }

    /**
     * Testing numbers between 0 and 9
     * @dataProvider digitsProvider
     */
    public function testDigits(float $number, string $word): void
    {
        self::assertEquals($word, $this->handle->toWords($number, $this->locale));
    }

    public function digitsProvider(): array
    {
        return [
            [0, 'cero'],
            [1, 'uno'],
            [2,'dos'],
            [3,'tres'],
            [4,'cuatro'],
            [5,'cinco'],
            [6,'seis'],
            [7,'siete'],
            [8,'ocho'],
            [9,'nueve'],
        ];
    }

    /**
     * Testing numbers between 10 and 99
     */
    public function testTens(): void
    {
        $tens = [
            11 => 'once',
            12 => 'doce',
            16 => 'dieciseis',
            19 => 'diecinueve',
            20 => 'veinte',
            21 => 'veintiuno',
            26 => 'veintiseis',
            30 => 'treinta',
            31 => 'treinta y uno',
            40 => 'cuarenta',
            43 => 'cuarenta y tres',
            50 => 'cincuenta',
            55 => 'cincuenta y cinco',
            60 => 'sesenta',
            67 => 'sesenta y siete',
            70 => 'setenta',
            79 => 'setenta y nueve',
        ];
        foreach ($tens as $number => $word) {
            self::assertEquals(
                $word,
                $this->handle->toWords($number, $this->locale)
            );
        }
    }

    /**
     * Testing numbers between 100 and 999
     */
    public function testHundreds(): void
    {
        $hundreds = [
            100 => 'cien',
            101 => 'ciento uno',
            199 => 'ciento noventa y nueve',
            203 => 'doscientos tres',
            287 => 'doscientos ochenta y siete',
            300 => 'trescientos',
            356 => 'trescientos cincuenta y seis',
            410 => 'cuatrocientos diez',
            434 => 'cuatrocientos treinta y cuatro',
            578 => 'quinientos setenta y ocho',
            689 => 'seiscientos ochenta y nueve',
            729 => 'setecientos veintinueve',
            894 => 'ochocientos noventa y cuatro',
            999 => 'novecientos noventa y nueve',
        ];
        foreach ($hundreds as $number => $word) {
            self::assertEquals(
                $word,
                $this->handle->toWords($number, $this->locale)
            );
        }
    }

    /**
     * Testing numbers between 1000 and 9999
     */
    public function testThousands(): void
    {
        $thousands = [
            1000 => 'mil',
            1001 => 'mil uno',
            1097 => 'mil noventa y siete',
            1104 => 'mil ciento cuatro',
            1243 => 'mil doscientos cuarenta y tres',
            2385 => 'dos mil trescientos ochenta y cinco',
            3766 => 'tres mil setecientos sesenta y seis',
            4196 => 'cuatro mil ciento noventa y seis',
            5846 => 'cinco mil ochocientos cuarenta y seis',
            6459 => 'seis mil cuatrocientos cincuenta y nueve',
            7232 => 'siete mil doscientos treinta y dos',
            8569 => 'ocho mil quinientos sesenta y nueve',
            9539 => 'nueve mil quinientos treinta y nueve',
        ];
        foreach ($thousands as $number => $word) {
            self::assertEquals(
                $word,
                $this->handle->toWords($number, $this->locale)
            );
        }
    }

    /**
     * @dataProvider exponentsProvider
     */
    public function testExponents($number, $word): void
    {
        self::assertEquals(
            $word,
            $this->handle->toWords($number, $this->locale)
        );
    }

    public function exponentsProvider(): array
    {
        return [
            [1_000_000, 'un millón'],
            [2_000_000, 'dos millones'],
            [3_333_000, 'tres millones trescientos treinta y tres mil'],
            [4_000_333, 'cuatro millones trescientos treinta y tres'],
            [
                5_333_333,
                'cinco millones trescientos treinta y tres mil trescientos treinta y tres',
            ],
            [6_000_000, 'seis millones'],
            [10_000_000, 'diez millones'],
        ];
    }

    public function testDecimals(): void
    {
        $values = [
            [123.45, 'ciento veintitres con cuarenta y cinco'],
            [20000.99, 'veinte mil con noventa y nueve'],
            [
                23456.87,
                'veintitres mil cuatrocientos cincuenta y seis con ochenta y siete',
            ],
        ];
        foreach ($values as $pairs) {
            self::assertEquals(
                $pairs[1],
                $this->handle->toWords($pairs[0], $this->locale)
            );
        }
    }

    public function testNegatives(): void
    {
        $values = [
            [-123.45, 'menos ciento veintitres con cuarenta y cinco'],
            [-20_000.99, 'menos veinte mil con noventa y nueve'],
            [
                -23_456.87,
                'menos veintitres mil cuatrocientos cincuenta y seis con ochenta y siete',
            ],
        ];
        foreach ($values as $pairs) {
            self::assertEquals(
                $pairs[1],
                $this->handle->toWords($pairs[0], $this->locale)
            );
        }
    }

    public function testCurrencies(): void
    {
        $tests = [
            '1.01' => 'uno dollar con uno centavo',
            '2.02' => 'dos dolares con dos centavos',
        ];

        foreach ($tests as $number => $word) {
            self::assertEquals(
                $word,
                $this->handle->toCurrency($number, $this->locale)
            );
        }
    }
}
