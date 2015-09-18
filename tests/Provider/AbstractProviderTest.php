<?php
/**
 * Created by Two Developers - Sven Motz und Jens Averkamp GbR
 * http://www.two-developers.com
 *
 * Author: Jens Averkamp
 */

namespace TwoDevs\ReferrerSpamDetector\Tests\Provider;

use Pdp\Parser;
use Pdp\PublicSuffixList;
use TwoDevs\ReferrerSpamDetector\Provider\ProviderInterface;

abstract class AbstractProviderTest extends \PHPUnit_Framework_TestCase
{
    /** @var Parser */
    protected $parser;

    protected function setUp()
    {
        parent::setUp();
        $file = realpath(__DIR__.'/../Fixtures/public-suffix-list.php');
        $this->parser = new Parser(
            new PublicSuffixList($file)
        );
    }

    protected function runProviderTest(ProviderInterface $provider)
    {
        $this->assertTrue($provider->isSpamReferrer($this->parser->parseUrl('http://example.org')));
        $this->assertTrue($provider->isSpamReferrer($this->parser->parseUrl('http://dev.example.org')));
        $this->assertTrue($provider->isSpamReferrer($this->parser->parseUrl('http://dev.example.com')));
        $this->assertFalse($provider->isSpamReferrer($this->parser->parseUrl('http://xyz.example.com')));
    }
}
