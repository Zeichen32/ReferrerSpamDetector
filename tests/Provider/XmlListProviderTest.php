<?php
/**
 * Created by Two Developers - Sven Motz und Jens Averkamp GbR
 * http://www.two-developers.com
 *
 * Author: Jens Averkamp
 */

namespace TwoDevs\ReferrerSpamDetector\Tests\Provider;


use TwoDevs\ReferrerSpamDetector\Provider\XmlListProvider;

class XmlistProviderTest extends AbstractProviderTest
{
    /**
     * @covers TwoDevs\ReferrerSpamDetector\Provider\XmlListProvider::isSpamReferrer
     */
    public function testIsSpamReferrer()
    {
        $provider = new XmlListProvider(__DIR__.'/../Fixtures/blocked.xml');
        $this->runProviderTest($provider);
    }
}
