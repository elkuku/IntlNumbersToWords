<?php

namespace App\Tests;

use IntlNumbersToWords\Exception\NumbersToWordsException;
use IntlNumbersToWords\Numbers;
use PHPUnit\Framework\TestCase;

/**
 * Class NumbersTest
 * @package tests
 * @covers \IntlNumbersToWords\Numbers
 */
class NumbersTest extends TestCase
{
    protected Numbers $object;

    public function setUp(): void
    {
        $this->object = new Numbers();
    }

    public function testToWordsObjectLocale(): void
    {
        $this->object->locale = 'de';
        self::assertEquals('eins', $this->object->toWords(1));
    }

    public function testToWordsObjectLocale2(): void
    {
        $this->object->locale = 'es_EC';
        self::assertEquals('uno', $this->object->toWords(1));
    }

    public function testToWordsInvalidLocale(): void
    {
        $this->expectException(NumbersToWordsException::class);
        $this->expectExceptionMessage('Unable to load locale class: IntlNumbersToWords\Words\Doesnotexist');
        $this->object->toWords(1, 'doesnotexist');
    }

    /**
     */
    public function testToCurrencyInvalidLocale(): void
    {
        $this->expectException(NumbersToWordsException::class);
        $this->expectExceptionMessage('Unable to load locale class: IntlNumbersToWords\Words\Doesnotexist');
        $this->object->toCurrency(1, 'doesnotexist');
    }

    public function testGetLocales(): void
    {
        $locales = $this->object->getLocales();
        self::assertCount(29, $locales);
        foreach ($locales as $locale) {
            self::assertMatchesRegularExpression(
                '#^[A-Z]{1}[a-z]{1}(_[A-Z]{1}[a-z]{1})?$#',
                $locale
            );
        }
    }

    public function testGetLocalesString(): void
    {
        $locales = $this->object->getLocales('de');
        self::assertCount(1, $locales);
        self::assertContains('De', $locales);
    }


    public function testGetLocalesArray(): void
    {
        $locales = $this->object->getLocales(['de', 'en_US']);

        self::assertCount(2, $locales);
        self::assertContains('De', $locales);
        self::assertContains('En_Us', $locales);
    }

    public function testAllLocales(): void
    {
    	/*
    	 *
    	 */
        // $this->markTestIncomplete(
        //     'temporary disabled.'
        // );

        $locales = $this->object->getLocales();
        foreach ($locales as $locale) {
            $nw   = new Numbers();
            $word = $nw->toWords(101, $locale);
            $this->assertNotEmpty(
                $word,
                'Word for "101" is empty in locale '.$locale
            );
        }
    }

    public function testLoadLocaleMissing(): void
    {
        $this->expectException(NumbersToWordsException::class);
        $this->expectExceptionMessage('Unable to load locale class: IntlNumbersToWords\Words\Doesnotexist');
        $this->object->getClassName('doesnotexist');
    }
}
