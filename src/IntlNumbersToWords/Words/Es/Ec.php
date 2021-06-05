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

namespace IntlNumbersToWords\Words\Es;

use IntlNumbersToWords\Words\Es;

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
class Ec extends Es
{
    /**
     * Locale name
     */
    public string $locale = 'es_EC';

    /**
     * The default currency name
     */
    protected string $defaultCurrency = 'USD'; // American dollar
}
