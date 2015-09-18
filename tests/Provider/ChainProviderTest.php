<?php
/**
 * Created by Two Developers - Sven Motz und Jens Averkamp GbR
 * http://www.two-developers.com
 *
 * Author: Jens Averkamp
 */

namespace TwoDevs\ReferrerSpamDetector\Tests\Provider;

use TwoDevs\ReferrerSpamDetector\Provider\ChainProvider;

class ChainProviderTest extends AbstractProviderTest
{
    /**
     * @covers TwoDevs\ReferrerSpamDetector\Provider\ChainProvider::isSpamReferrer
     */
    public function testIsSpamReferrer()
    {
        $provider1 = $this
            ->getMockBuilder('TwoDevs\ReferrerSpamDetector\Provider\ProviderInterface')
            ->setMethods(['isSpamReferrer'])
            ->getMock();

        $provider2 = clone $provider1;

        $provider1
            ->expects($this->exactly(3))
            ->method('isSpamReferrer')
            ->will($this->onConsecutiveCalls(true, false, false));

        $provider2
            ->expects($this->exactly(2))
            ->method('isSpamReferrer')
            ->will($this->onConsecutiveCalls(true, false));

        $provider = new ChainProvider([$provider1, $provider2]);

        // Provider 1 match
        $this->assertTrue($provider->isSpamReferrer($this->parser->parseUrl('http://example.org')));

        // Provider 2 match
        $this->assertTrue($provider->isSpamReferrer($this->parser->parseUrl('http://foo.example.org')));

        // No Provider match
        $this->assertFalse($provider->isSpamReferrer($this->parser->parseUrl('http://bar.example.org')));

        // Should be match without call any provider
        $this->assertTrue($provider->isSpamReferrer($this->parser->parseUrl('http://example.org')));
    }
}
