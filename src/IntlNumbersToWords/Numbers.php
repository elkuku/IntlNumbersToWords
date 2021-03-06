<?php

namespace IntlNumbersToWords;

/**
 * Numbers
 *
 * PHP version 5
 *
 * Copyright (c) 1997-2006 The PHP Group
 *
 * This source file is subject to version 3.01 of the PHP license,
 * that is bundled with this package in the file LICENSE, and is
 * available at through the world-wide-web at
 * http://www.php.net/license/3_01.txt
 * If you did not receive a copy of the PHP license and are unable to
 * obtain it through the world-wide-web, please send a note to
 * license@php.net so we can mail you a copy immediately.
 *
 * Authors: Piotr Klaban <makler@man.torun.pl>
 *
 * @category Numbers
 * @package  Numbers_Words
 * @author   Piotr Klaban <makler@man.torun.pl>
 * @license  PHP 3.01 http://www.php.net/license/3_01.txt
 * @version  SVN: $Id$
 * @link     http://pear.php.net/package/Numbers_Words
 */

use IntlNumbersToWords\Exception\NumbersToWordsException;

/**
 * The Numbers class provides method to convert arabic numerals to words.
 *
 * @category Numbers
 * @package  Numbers_Words
 * @author   Piotr Klaban <makler@man.torun.pl>
 * @license  PHP 3.01 http://www.php.net/license/3_01.txt
 * @link     http://pear.php.net/package/Numbers_Words
 * @since    PHP 4.2.3
 * @access   public
 */
class Numbers
{
    /**
     * Masculine gender, for languages that need it
     */
    public const GENDER_MASCULINE = 0;

    /**
     * Feminine gender, for languages that need it
     */
    public const GENDER_FEMININE = 1;

    /**
     * Neuter gender, for languages that need it
     */
    public const GENDER_NEUTER = 2;

    /**
     * This is not an actual gender; some languages
     * have different ways of numbering actual things
     * (e.g. Romanian: "un nor, doi nori" for "one cloud, two clouds")
     * and for just counting in an abstract manner
     * (e.g. Romanian: "unu, doi" for "one, two"
     */
    public const GENDER_ABSTRACT = 3;

    /**
     * Default Locale name
     */
    public string $locale = 'en_US';

    /**
     * Default decimal mark
     */
    public string $decimalPoint = '.';

    protected string $languageName = 'English';

    /**
     * Converts a number to its word representation
     *
     * @param float  $num      A float between -infinity and infinity inclusive :)
     *                         that should be converted to a words representation
     * @param string $locale   Language name abbreviation. Optional. Defaults to
     *                         current loaded driver or en_US if any.
     *
     * @return string  The corresponding word representation
     * @throws \IntlNumbersToWords\Exception\NumbersToWordsException
     * @author       Piotr Klaban <makler@man.torun.pl>
     * @since        PHP 4.2.3
     */
    public function toWords(
        float $num,
        string $locale = '',
    ): string {
        if (empty($locale)) {
            $locale = $this->locale;
        }

        if (empty($locale)) {
            $locale = 'en_US';
        }

        $className = $this->getClassName($locale);

        if (false === class_exists($className)) {
            throw new \UnexpectedValueException(
                sprintf('Class"%s" could not be found :(', $className)
            );
        }

        /* @type AbstractWords $obj */
        $obj = new $className();

        if ($obj instanceof self) {
            throw new \UnexpectedValueException(
                sprintf(
                    'Class "%s" must extend "AbstractWords" instead of "Numbers" :(',
                    $className
                )
            );
        }

        return trim($obj->fromNumber($num));
    }

    /**
     * Converts a currency value to word representation (1.02 => one dollar two cents)
     * If the number has not any fraction part, the "cents" number is omitted.
     *
     * @param float       $num          A float/integer/string number representing currency value
     *
     * @param string      $locale       Language name abbreviation. Optional. Defaults to en_US.
     *
     * @param string      $intCurr      International currency symbol
     *                                  as defined by the ISO 4217 standard (three characters).
     *                                  E.g. 'EUR', 'USD', 'PLN'. Optional.
     *                                  Defaults to $def_currency defined in the language class.
     *
     * @param string|null $decimalPoint Decimal mark symbol
     *                                  E.g. '.', ','. Optional.
     *                                  Defaults to $decimalPoint defined in the language class.
     *
     * @return string  The corresponding word representation
     *
     * @access public
     * @author Piotr Klaban <makler@man.torun.pl>
     * @since  PHP 4.2.3
     */
    public function toCurrency(
        float $num,
        string $locale = 'en_US',
        string $intCurr = '',
        string $decimalPoint = null
    ): string {
        $className = $this->getClassName($locale);

        /* @type Numbers $obj */
        $obj = new $className();

        if (is_null($decimalPoint)) {
            $decimalPoint = $this->decimalPoint;
        }

        // round if a float is passed, use Math_BigInteger otherwise
        if (is_float($num)) {
            $num = round($num, 2);
        }

        $num = $this->normalizeNumber($num, $decimalPoint);

        if (!str_contains($num, $decimalPoint)) {
            return trim($obj->toCurrencyWords($intCurr, $num));
        }

        $currency = explode($decimalPoint, $num, 2);

        $len = strlen($currency[1]);

        if ($len === 1) {
            // add leading zero
            $currency[1] .= '0';
        } elseif ($len > 2) {
            // get the 3rd digit after the comma
            $roundDigit = substr($currency[1], 2, 1);

            // cut everything after the 2nd digit
            $currency[1] = substr($currency[1], 0, 2);

            if ($roundDigit >= 5) {
                throw new \UnexpectedValueException(
                    'RoundDigit value >=5 is not supported (ATM) :('
                );

                // round up without losing precision
                include_once "Math/BigInteger.php";

                $int = new Math_BigInteger(join($currency));
                $int = $int->add(new Math_BigInteger(1));
                $intStr = $int->toString();

                $currency[0] = substr($intStr, 0, -2);
                $currency[1] = substr($intStr, -2);

                // check if the rounded decimal part became zero
                if ($currency[1] == '00') {
                    $currency[1] = false;
                }
            }
        }

        return trim(
            $obj->toCurrencyWords($intCurr, $currency[0], $currency[1])
        );
    }

    /**
     * Lists available locales for Numbers_Words
     *
     * @param mixed|null $locales string/array of strings $locale
     *                            Optional searched language name abbreviation.
     *                            Default: all available locales.
     *
     * @return array   The available locales (optionally only the requested ones)
     * @author Piotr Klaban <makler@man.torun.pl>
     * @author Bertrand Gugger, bertrand at toggg dot com
     */
    public function getLocales(mixed $locales = null): array
    {
        $ret = [];
        if (isset($locales)) {
            if (is_string($locales)) {
                $locales = [$locales];
            }
        } else {
            $locales = [];
        }

        array_walk($locales, function(&$part){$part = $this->getLocaleDir($part);});

        $dname = __DIR__.'/Words/';

        $sfiles = glob($dname.'??.php');
        foreach ($sfiles as $fname) {
            $lname = substr($fname, -6, 2);
            if (is_file($fname) && is_readable($fname)
                && (count($locales) === 0 || in_array($lname, $locales))
            ) {
                $ret[] = $lname;
            }
        }

        $mfiles = glob($dname.'??/??.php');
        foreach ($mfiles as $fname) {
            $lname = str_replace(['/', '\\'], '_', substr($fname, -9, 5));
            $xname = substr($fname, -9, 5);
            if (is_file($fname) && is_readable($fname)
                && (count($locales) === 0 || in_array($lname, $locales)|| in_array($xname, $locales))
            ) {
                $ret[] = $lname;
            }
        }

        sort($ret);

        return $ret;
    }

    /**
     * Load the given locale and return class name
     *
     * @param string $locale Locale key, e.g. "de" or "en_US"
     *
     * @return string Locale class name
     *
     * @throws NumbersToWordsException When the class cannot be loaded
     */
    public function getClassName(string $locale): string
    {
        if ('en_100' === $locale) {
            $locale = 'en_En100';
        }

        $className = 'IntlNumbersToWords\\Words\\'.$this->getLocaleClass($locale);

        if (!class_exists($className)) {
            throw new NumbersToWordsException(
                'Unable to load locale class: '.$className
            );
        }

        return $className;
    }

    /**
     * Removes redundant spaces, thousands separators, etc.
     *
     * @param string      $num          Some number
     * @param string|null $decimalPoint The decimal mark, e.g. "." or ","
     */
    public function normalizeNumber(
        string $num,
        string $decimalPoint = null
    ): string {
        if (is_null($decimalPoint)) {
            $decimalPoint = $this->decimalPoint;
        }

        return preg_replace('/[^-'.preg_quote($decimalPoint).'0-9]/', '', $num);
    }

    /**
     * Get the native language name.
     */
    public function getLanguageName(): string
    {
        return $this->languageName;
    }

    private function getLocaleDir(string $locale): string
    {
        $parts = $this->explodeLocale($locale);
        return implode('/', $parts);
    }

    private function getLocaleClass(string $locale): string
    {
        $parts = $this->explodeLocale($locale);
        return implode('\\', $parts);
    }

    private function explodeLocale(string $locale):array
    {
        $parts = explode('_', $locale);
        array_walk($parts, static function(&$part){
            $part = ucfirst(strtolower($part));}
        );

        return $parts;
    }
}
