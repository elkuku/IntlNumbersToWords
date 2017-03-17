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
 * @author   Xavier Noguer   <xnoguer.php@gmail.com>
 * @author   Martin Marrese  <mmare@mecon.gov.ar>
 * @license  PHP 3.01 http://www.php.net/license/3_01.txt
 * @version  SVN: $Id$
 * @link     http://pear.php.net/package/Numbers_Words
 */

namespace IntlNumbersToWords\Words\es;

use IntlNumbersToWords\Numbers;

/**
 * Class for translating numbers into Ecuadorian Spanish.
 * It supports up to decallones (10^6).
 * It doesn't support spanish tonic accents (acentos).
 *
 * @category Numbers
 * @package  Numbers_Words
 * @author   Xavier Noguer   <xnoguer.php@gmail.com>
 * @author   Martin Marrese  <mmare@mecon.gov.ar>
 * @author   Nikolai Plath   <der.el.kuku@gmail.com>
 * @license  PHP 3.01 http://www.php.net/license/3_01.txt
 * @link     http://pear.php.net/package/Numbers_Words
 */
class EC extends Numbers
{
    /**
     * Locale name
     * @var string
     * @access public
     */
    public $locale = 'es_EC';

    /**
     * Language name in English
     * @var string
     * @access public
     */
    public $lang = 'Spanish';

    /**
     * The word for the minus sign
     * @var string
     * @access private
     */
    public $minus = 'menos';

    /**
     * Native language name
     * @var string
     * @access public
     */
    protected $languageName = 'Español';

    /**
     * The sufixes for exponents (singular and plural)
     * @var array
     * @access private
     */
    protected $exponent = [
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
     * @var array
     * @access private
     */
    protected $digits = [
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
     * @var string
     * @access private
     */
    protected $sep = ' ';

    /**
     * The currency names (based on the below links,
     * informations from central bank websites and on encyclopedias)
     *
     * @var array
     * @link   http://30-03-67.dreamstation.com/currency_alfa.htm World Currency Information
     * @link   http://www.jhall.demon.co.uk/currency/by_abbrev.html World currencies
     * @link   http://www.shoestring.co.kr/world/p.visa/change.htm Currency names in English
     * @access private
     */
    protected $currency_names = [
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
        'USD' => [['dollar'], ['cent']],
        'YUM' => [['dinars'], ['para']],
        'ZAR' => [['rand'], ['cent']],
    ];

    /**
     * The default currency name
     * @var string
     * @access public
     */
    protected $defaultCurrency = 'USD'; // American dollar

    /**
     * Converts a number to its word representation
     * in Argentinian Spanish.
     *
     * @param float   $num    An float between -infinity and infinity inclusive :)
     *                        that should be converted to a words representation
     * @param integer $power  The power of ten for the rest of the number to the right.
     *                        For example toWords(12,3) should give "doce mil".
     *                        Optional, defaults to 0.
     *
     * @return string  The corresponding word representation
     *
     * @access protected
     * @author Martin Marrese
     * @since  Numbers_Words 0.16.3
     */
    protected function convertToWords($num, $power = 0)
    {
        // The return string;
        $ret = '';

        // add a the word for the minus sign if necessary
        if (substr($num, 0, 1) == '-') {
            $ret = $this->sep.$this->minus;
            $num = substr($num, 1);
        }

        // strip excessive zero signs
        $num = preg_replace('/^0+/', '', $num);

        $num_tmp = explode('.', $num);

        $num = $num_tmp[0];
        $dec = (@$num_tmp[1]) ? $num_tmp[1] : '';

        if (strlen($num) > 6) {
            $current_power = 6;
            // check for highest power
            if (isset($this->exponent[$power])) {
                // convert the number above the first 6 digits
                // with it's corresponding $power.
                $snum = substr($num, 0, -6);
                $snum = preg_replace('/^0+/', '', $snum);
                if ($snum !== '') {
                    $ret .= $this->_toWords($snum, $power + 6);
                }
            }
            $num = substr($num, -6);
            if ($num == 0) {
                return $ret;
            }
        } elseif ($num == 0 || $num == '') {
            return (' '.$this->digits[0]);
        } else {
            $current_power = strlen($num);
        }

        // See if we need "thousands"
        $thousands = floor($num / 1000);
        if ($thousands == 1) {
            $ret .= $this->sep.'mil';
        } elseif ($thousands > 1) {
            $ret .= $this->_toWords($thousands, 3);
        }

        // values for digits, tens and hundreds
        $h = floor(($num / 100) % 10);
        $t = floor(($num / 10) % 10);
        $d = floor($num % 10);

        // cientos: doscientos, trescientos, etc...
        switch ($h) {
            case 1:
                if (($d == 0) and ($t == 0)) { // is it's '100' use 'cien'
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
                $ret .= $this->sep.$this->digits[$h].'cientos';
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
        switch ($t) {
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
                if ($d == 0) {
                    $ret .= $this->sep.'veinte';
                } else {
                    if (($power > 0) and ($d == 1)) {
                        $ret .= $this->sep.'veintiún';
                    } else {
                        $ret .= $this->sep.'veinti'.$this->digits[$d];
                    }
                }
                break;

            case 1:
                switch ($d) {
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
                        $ret .= $this->sep.'dieci'.$this->digits[$d];
                        break;
                }
                break;
        }

        // add digits only if it is a multiple of 10 and not 1x or 2x
        if (($t != 1) and ($t != 2) and ($d > 0)) {

            // don't add 'y' for numbers below 10
            if ($t != 0) {
                // use 'un' instead of 'uno' when there is a suffix ('mil', 'millones', etc...)
                if (($power > 0) and ($d == 1)) {
                    $ret .= $this->sep.' y un';
                } else {
                    $ret .= $this->sep.'y '.$this->digits[$d];
                }
            } else {
                if (($power > 0) and ($d == 1)) {
                    $ret .= $this->sep.'un';
                } else {
                    $ret .= $this->sep.$this->digits[$d];
                }
            }
        }

        if ($power > 0) {
            if (isset($this->exponent[$power])) {
                $lev = $this->exponent[$power];
            }

            if (!isset($lev) || !is_array($lev)) {
                return null;
            }

            // if it's only one use the singular suffix
            if (($d == 1) and ($t == 0) and ($h == 0)) {
                $suffix = $lev[0];
            } else {
                $suffix = $lev[1];
            }
            if ($num != 0) {
                $ret .= $this->sep.$suffix;
            }
        }

        if ($dec) {
            $dec = $this->_toWords(trim($dec));
            $ret .= ' con '.trim($dec);
        }

        return $ret;
    }

    /**
     * Converts a currency value to its word representation
     * (with monetary units) in Agentinian Spanish language
     *
     * @param integer         $int_curr         An international currency symbol
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
    function toCurrencyWords($int_curr, $decimal, $fraction = false, $convert_fraction = true)
    {
        $int_curr = strtoupper($int_curr);
        if (!isset($this->currency_names[$int_curr])) {
            $int_curr = $this->defaultCurrency;
        }

        $curr_names = $this->currency_names[$int_curr];

        $lev = ($decimal == 1) ? 0 : 1;
        if ($lev > 0) {
            if (count($curr_names[0]) > 1) {
                $ret = $curr_names[0][$lev];
            } else {
                $ret = $curr_names[0][0].'s';
            }

        } else {
            $ret = $curr_names[0][0];
        }

        $ret .= $this->sep.trim($this->_toWords($decimal));

        if ($fraction !== false) {
            if ($convert_fraction) {
                $ret .= $this->sep.'con'.$this->sep.trim($this->_toWords($fraction));
            } else {
                $ret .= $this->sep.'con'.$this->sep.$fraction;
            }

            $lev = ($fraction == 1) ? 0 : 1;
            if ($lev > 0) {
                if (count($curr_names[1]) > 1) {
                    $ret .= $this->sep.$curr_names[1][$lev];
                } else {
                    $ret .= $this->sep.$curr_names[1][0].'s';
                }

            } else {
                $ret .= $this->sep.$curr_names[1][0];
            }
        }

        return $ret;
    }
}
