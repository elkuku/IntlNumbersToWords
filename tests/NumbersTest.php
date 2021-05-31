<?php

namespace tests;

use IntlNumbersToWords\Exception\NumbersToWordsException;
use IntlNumbersToWords\Numbers;
use PHPUnit\Framework\TestCase;

/**
 * Class NumbersTest
 * @package tests
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
        $this->expectExceptionMessage('Unable to load locale class IntlNumbersToWords\Words\doesnotexist');
        $this->object->toWords(1, 'doesnotexist');
    }

    /**
     * @expectedException \IntlNumbersToWords\Exception\NumbersToWordsException
     * @expectedExceptionMessage Unable to load locale class IntlNumbersToWords\Words\doesnotexist
     */
    public function testToCurrencyInvalidLocale(): void
    {
        $this->expectException(NumbersToWordsException::class);
        $this->expectExceptionMessage('Unable to load locale class IntlNumbersToWords\Words\doesnotexist');
        $this->object->toCurrency(1, 'doesnotexist');
    }

    public function testGetLocales(): void
    {
        $locales = $this->object->getLocales();
        // $this->assertInternalType('array', $locales);
        self::assertCount(29, $locales);
        foreach ($locales as $locale) {
            self::assertMatchesRegularExpression(
                '#^[a-z]{2}(_[A-Z]{2})?$#',
                $locale
            );
        }
    }

    public function testGetLocalesString(): void
    {
        $locales = $this->object->getLocales('de');
        // $this->assertInternalType('array', $locales);
        self::assertCount(1, $locales);
        self::assertContains('de', $locales);
    }


    public function testGetLocalesArray(): void
    {
        $locales = $this->object->getLocales(['de', 'en_US']);
        // $this->assertInternalType('array', $locales);
        self::assertCount(2, $locales);
        self::assertContains('de', $locales);
        self::assertContains('en_US', $locales);
    }

    public function testAllLocales(): void
    {
    	/*
    	 *
    	 */
        $this->markTestIncomplete(
            'temporary disabled.'
        );

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

    /**
     * @expectedException \IntlNumbersToWords\Exception\NumbersToWordsException
     * @expectedExceptionMessage Unable to load locale class IntlNumbersToWords\Words\doesnotexist
     */
    public function testLoadLocaleMissing(): void
    {
        $this->expectException(NumbersToWordsException::class);
        $this->expectExceptionMessage('Unable to load locale class IntlNumbersToWords\Words\doesnotexist');
        $this->object->loadLocale('doesnotexist');
    }
}
