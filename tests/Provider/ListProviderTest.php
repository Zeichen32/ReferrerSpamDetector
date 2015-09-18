<?php
/**
 * Created by Two Developers - Sven Motz und Jens Averkamp GbR
 * http://www.two-developers.com
 *
 * Author: Jens Averkamp
 */

namespace TwoDevs\ReferrerSpamDetector\Tests\Provider;

use TwoDevs\ReferrerSpamDetector\Provider\ListProvider;

class ListProviderTest extends AbstractProviderTest
{
    /**
     * @covers TwoDevs\ReferrerSpamDetector\Provider\ListProvider::isSpamReferrer
     */
    public function testIsSpamReferrer()
    {
        $provider = new ListProvider(json_decode(file_get_contents(__DIR__.'/../Fixtures/blocked.json')));

        $this->assertTrue($provider->isSpamReferrer($this->parser->parseUrl('http://example.org')));
        $this->assertTrue($provider->isSpamReferrer($this->parser->parseUrl('http://dev.example.org')));
        $this->assertTrue($provider->isSpamReferrer($this->parser->parseUrl('http://dev.example.com')));
        $this->assertTrue($provider->isSpamReferrer($this->parser->parseUrl('http://xyz.example.com')));
    }
}
