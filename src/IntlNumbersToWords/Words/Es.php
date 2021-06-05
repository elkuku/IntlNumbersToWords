<?php
/**
 * Numbers_Words
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
 * @category Numbers
 * @package  Numbers_Words
 * @author   Xavier Noguer
 * @license  PHP 3.01 http://www.php.net/license/3_01.txt
 * @version  SVN: $Id$
 * @link     http://pear.php.net/package/Numbers_Words
 */

namespace IntlNumbersToWords\Words;

use IntlNumbersToWords\AbstractWords;

/**
 * Class for translating numbers into Spanish (Castellano).
 * It supports up to decallones (10^6).
 * It doesn't support spanish tonic accents (acentos).
 *
 * @category Numbers
 * @package  Numbers_Words
 * @author   Xavier Noguer
 * @license  PHP 3.01 http://www.php.net/license/3_01.txt
 * @link     http://pear.php.net/package/Numbers_Words
 */
class Es extends AbstractWords
{
    /**
     * Locale name
     */
    public string $locale = 'es';

    /**
     * Language name in English
     */
    public string $lang = 'Spanish';

    /**
     * Native language name
     */
    public string $languageName = 'Español';

    /**
     * The word for the minus sign
     */
    public string $minus = 'menos';

    /**
     * The suffixes for exponents (singular and plural)
     */
    protected array $exponent
        = [
            0  => ['', ''],
            3  => ['mil', 'mil'],
            6  => ['millón', 'millones'],
            12 => ['billón', 'billones'],
            18 => ['trilón', 'trillones'],
            24 => ['cuatrillón', 'cuatrillones'],
            30 => ['quintillón', 'quintillones'],
            36 => ['sextillón', 'sextillones'],
            42 => ['septillón', 'septillones'],
            48 => ['octallón', 'octallones'],
            54 => ['nonallón', 'nonallones'],
            60 => ['decallón', 'decallones'],
        ];

    /**
     * The array containing the digits (indexed by the digits themselves).
     */
    protected array $digits
        = [
            0 => 'cero',
            'uno',
            'dos',
            'tres',
            'cuatro',
            'cinco',
            'seis',
            'siete',
            'ocho',
            'nueve',
        ];

    /**
     * The word separator
     */
    protected string $sep = ' ';

    /**
     * The currency names (based on the below links,
     * informations from central bank websites and on encyclopedias)
     *
     * @link   http://30-03-67.dreamstation.com/currency_alfa.htm World Currency Information
     * @link   http://www.jhall.demon.co.uk/currency/by_abbrev.html World currencies
     * @link   http://www.shoestring.co.kr/world/p.visa/change.htm Currency names in English
     * @access private
     */
    protected array $currencyNames
        = [
            'ALL' => [['lek'], ['qindarka']],
            'AUD' => [['Australian dollar'], ['cent']],
            'ARS' => [['Peso'], ['centavo']],
            'BAM' => [['convertible marka'], ['fenig']],
            'BGN' => [['lev'], ['stotinka']],
            'BRL' => [['real'], ['centavos']],
            'BYR' => [['Belarussian rouble'], ['kopiejka']],
            'CAD' => [['Canadian dollar'], ['cent']],
            'CHF' => [['Swiss franc'], ['rapp']],
            'CYP' => [['Cypriot pound'], ['cent']],
            'CZK' => [['Czech koruna'], ['halerz']],
            'DKK' => [['Danish krone'], ['ore']],
            'EEK' => [['kroon'], ['senti']],
            'EUR' => [['euro'], ['euro-cent']],
            'GBP' => [['pound', 'pounds'], ['pence']],
            'HKD' => [['Hong Kong dollar'], ['cent']],
            'HRK' => [['Croatian kuna'], ['lipa']],
            'HUF' => [['forint'], ['filler']],
            'ILS' => [['new sheqel', 'new sheqels'], ['agora', 'agorot']],
            'ISK' => [['Icelandic krona'], ['aurar']],
            'JPY' => [['yen'], ['sen']],
            'LTL' => [['litas'], ['cent']],
            'LVL' => [['lat'], ['sentim']],
            'MKD' => [['Macedonian dinar'], ['deni']],
            'MTL' => [['Maltese lira'], ['centym']],
            'NOK' => [['Norwegian krone'], ['oere']],
            'PLN' => [['zloty', 'zlotys'], ['grosz']],
            'ROL' => [['Romanian leu'], ['bani']],
            'RUB' => [['Russian Federation rouble'], ['kopiejka']],
            'SEK' => [['Swedish krona'], ['oere']],
            'SIT' => [['Tolar'], ['stotinia']],
            'SKK' => [['Slovak koruna'], []],
            'TRL' => [['lira'], ['kurus']],
            'UAH' => [['hryvna'], ['cent']],
            'USD' => [['dollar', 'dolares'], ['centavo', 'centavos']],
            'YUM' => [['dinars'], ['para']],
            'ZAR' => [['rand'], ['cent']],
        ];

    /**
     * Converts a number to its word representation
     * in Spanish (Castellano).
     *
     * @param float   $num    An integer between -infinity and infinity inclusive :)
     *                        that should be converted to a words representation
     * @param integer $power  The power of ten for the rest of the number to the right.
     *                        For example toWords(12,3) should give "doce mil".
     *                        Optional, defaults to 0.
     *
     * @return string  The corresponding word representation
     *
     * @author Xavier Noguer
     * @since  Numbers_Words 0.16.3
     */
    public function fromNumber(
        float $num,
        int $power = 0,
        string $powSuffix = ''
    ): string {
        $ret = '';

        // add a the word for the minus sign if necessary
        if ($num < 0) {
            $ret = $this->sep.$this->minus;
            $num = -$num;
        }

        // Convert the value to string to overcome PHP rounding errors for floats :(
        $stringVal = (string)$num;

        $parts = explode('.', $stringVal);

        $integer = (int)$parts[0];
        $fraction = isset($parts[1]) ? (int)$parts[1] : 0;

        $stringNumber = (string)$integer;

        // $integer = (int)floor($num);
        // $fractionPart = $num - floor($num);
        // $fraction = (int)floor($fractionPart * 100);

        // strip excessive zero signs
        // $num = preg_replace('/^0+/', '', $num);

        // $numTmp = explode('.', $num);
        //
        // $num = $numTmp[0];
        // $dec = (@$numTmp[1]) ? $numTmp[1] : '';

        $num = $integer;

        if (strlen($num) > 6) {
            // $current_power = 6;
            // check for highest power
            if (isset($this->exponent[$power])) {
                // convert the number above the first 6 digits
                // with it's corresponding $power.
                $snum = substr($stringNumber, 0, -6);
                $snum = ltrim($snum, '0');
                if ($snum !== '') {
                    $ret .= $this->fromNumber($snum, $power + 6);
                }
            }
            $num = substr($stringNumber, -6);
            $integer = (integer)$num;
            if ($num == 0) {
                return $ret;
            }
        } elseif ($integer === 0) {
            return (' '.$this->digits[0]);
        }

        // See if we need "thousands"
        $thousands = (int)floor($integer / 1000);
        if ($thousands === 1) {
            $ret .= $this->sep.'mil';
        } elseif ($thousands > 1) {
            $ret .= $this->fromNumber($thousands, 3);
        }

        // values for digits, tens and hundreds
        $hundreds = (int)floor(($integer / 100) % 10);
        $tens = (int)floor(($integer / 10) % 10);
        $digits = (int)floor($integer % 10);

        // cientos: doscientos, trescientos, etc...
        switch ($hundreds) {
            case 1:
                if ($digits === 0 && $tens === 0) {
                    // is it's '100' use 'cien'
                    $ret .= $this->sep.'cien';
                } else {
                    $ret .= $this->sep.'ciento';
                }
                break;
            case 2:
            case 3:
            case 4:
            case 6:
            case 8:
                $ret .= $this->sep.$this->digits[$hundreds].'cientos';
                break;
            case 5:
                $ret .= $this->sep.'quinientos';
                break;
            case 7:
                $ret .= $this->sep.'setecientos';
                break;
            case 9:
                $ret .= $this->sep.'novecientos';
                break;
        }

        // decenas: veinte, treinta, etc...
        switch ($tens) {
            case 9:
                $ret .= $this->sep.'noventa';
                break;

            case 8:
                $ret .= $this->sep.'ochenta';
                break;

            case 7:
                $ret .= $this->sep.'setenta';
                break;

            case 6:
                $ret .= $this->sep.'sesenta';
                break;

            case 5:
                $ret .= $this->sep.'cincuenta';
                break;

            case 4:
                $ret .= $this->sep.'cuarenta';
                break;

            case 3:
                $ret .= $this->sep.'treinta';
                break;

            case 2:
                if ($digits === 0) {
                    $ret .= $this->sep.'veinte';
                } elseif ($power > 0 && $digits === 1) {
                    $ret .= $this->sep.'veintiún';
                } else {
                    $ret .= $this->sep.'veinti'.$this->digits[$digits];
                }
                break;

            case 1:
                switch ($digits) {
                    case 0:
                        $ret .= $this->sep.'diez';
                        break;

                    case 1:
                        $ret .= $this->sep.'once';
                        break;

                    case 2:
                        $ret .= $this->sep.'doce';
                        break;

                    case 3:
                        $ret .= $this->sep.'trece';
                        break;

                    case 4:
                        $ret .= $this->sep.'catorce';
                        break;

                    case 5:
                        $ret .= $this->sep.'quince';
                        break;

                    case 6:
                    case 7:
                    case 9:
                    case 8:
                        $ret .= $this->sep.'dieci'.$this->digits[$digits];
                        break;
                }
                break;
        }

        // add digits only if it is a multiple of 10 and not 1x or 2x
        if (($tens !== 1) && ($tens !== 2) && ($digits > 0)) {
            // don't add 'y' for numbers below 10
            if ($tens !== 0) {
                // use 'un' instead of 'uno' when there is a suffix ('mil', 'millones', etc...)
                if (($power > 0) && ($digits === 1)) {
                    $ret .= $this->sep.' y un';
                } else {
                    $ret .= $this->sep.'y '.$this->digits[$digits];
                }
            } elseif (($power > 0) && ($digits === 1)) {
                $ret .= $this->sep.'un';
            } else {
                $ret .= $this->sep.$this->digits[$digits];
            }
        }

        if ($power > 0) {
            if (isset($this->exponent[$power])) {
                $lev = $this->exponent[$power];
            }

            if (!isset($lev) || !is_array($lev)) {
                return '';
            }

            // if it's only one use the singular suffix
            if (($digits === 1) && ($tens === 0) && ($hundreds === 0)) {
                $suffix = $lev[0];
            } else {
                $suffix = $lev[1];
            }
            if ($num !== 0) {
                $ret .= $this->sep.$suffix;
            }
        }

        if ($fraction) {
            $ret .= ' con '.trim($this->fromNumber($fraction));
        }

        return $ret;
    }

    /**
     * Converts a currency value to its word representation
     * (with monetary units) in Agentinian Spanish language
     *
     * @param integer         $intCurr          An international currency symbol
     *                                          as defined by the ISO 4217 standard (three characters)
     * @param integer         $decimal          A money total amount without fraction part (e.g. amount of dollars)
     * @param integer|boolean $fraction         Fractional part of the money amount (e.g. amount of cents)
     *                                          Optional. Defaults to false.
     * @param boolean         $convert_fraction Convert fraction to words (left as numeric if set to false).
     *                                          Optional. Defaults to true.
     *
     * @return string  The corresponding word representation for the currency
     *
     * @access public
     * @author Martin Marrese
     */
    public function toCurrencyWords(
        $intCurr,
        $decimal,
        $fraction = false,
        $convert_fraction = true
    ) {
        $intCurr = strtoupper($intCurr);
        if (!isset($this->currencyNames[$intCurr])) {
            $intCurr = $this->defaultCurrency;
        }

        $currNames = $this->currencyNames[$intCurr];

        $lev = ($decimal == 1) ? 0 : 1;

        $ret = '';
        $ret .= trim($this->fromNumber($decimal)).$this->sep;

        if ($lev > 0) {
            if (count($currNames[0]) > 1) {
                $ret .= $currNames[0][$lev];
            } else {
                $ret .= $currNames[0][0].'s';
            }
        } else {
            $ret .= $currNames[0][0];
        }

        if ($fraction !== false) {
            if ($convert_fraction) {
                $ret .= $this->sep.'con'.$this->sep.trim(
                        $this->fromNumber($fraction)
                    );
            } else {
                $ret .= $this->sep.'con'.$this->sep.$fraction;
            }

            $lev = ($fraction == 1) ? 0 : 1;
            if ($lev > 0) {
                if (count($currNames[1]) > 1) {
                    $ret .= $this->sep.$currNames[1][$lev];
                } else {
                    $ret .= $this->sep.$currNames[1][0].'s';
                }
            } else {
                $ret .= $this->sep.$currNames[1][0];
            }
        }

        return $ret;
    }
}
