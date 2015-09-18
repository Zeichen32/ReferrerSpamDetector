<?php
/**
 * Created by Two Developers - Sven Motz und Jens Averkamp GbR
 * http://www.two-developers.com
 *
 * Author: Jens Averkamp
 */

namespace TwoDevs\ReferrerSpamDetector\Tests\Provider;

use TwoDevs\ReferrerSpamDetector\Provider\RegexProvider;

class RegexProviderTest extends AbstractProviderTest
{
    /**
     * @covers TwoDevs\ReferrerSpamDetector\Provider\RegexProvider::isSpamReferrer
     */
    public function testIsSpamReferrer()
    {
        $provider = new RegexProvider('/example\.org/');
        $this->assertTrue($provider->isSpamReferrer($this->parser->parseUrl('http://example.org')));
        $this->assertTrue($provider->isSpamReferrer($this->parser->parseUrl('http://dev.example.org')));
        $this->assertFalse($provider->isSpamReferrer($this->parser->parseUrl('http://dev.example.com')));

        $provider = new RegexProvider('/example\.(org|com)/');
        $this->assertTrue($provider->isSpamReferrer($this->parser->parseUrl('http://example.org')));
        $this->assertTrue($provider->isSpamReferrer($this->parser->parseUrl('http://dev.example.org')));
        $this->assertTrue($provider->isSpamReferrer($this->parser->parseUrl('http://dev.example.com')));
    }
}
