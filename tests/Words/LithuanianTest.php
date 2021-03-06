<?php
namespace App\Tests\Words;

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4 autoindent: */
use IntlNumbersToWords\Numbers;
use PHPUnit\Framework\TestCase;

/**
 * Numbers_Words class extension to spell numbers in Lithuanian.
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
 * @author     Igor Feghali <ifeghali@php.net>
 * @copyright  1997-2008 The PHP Group
 * @license    http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version    SVN: $Id$
 * @link       http://pear.php.net/package/Numbers_Words
 *
 * @covers \IntlNumbersToWords\Words\Lt
 */

class LithuanianTest extends TestCase
{
    protected $handle;

    public function setUp(): void
    {
        $this->handle = new Numbers();
    }

    /**
     * Testing utf-8
     */
    function testBug18248()
    {
        $number = $this->handle->toWords(726, 'lt');
        $this->assertEquals('septyni šimtai dvidešimt šeši', $number);
    }
}
