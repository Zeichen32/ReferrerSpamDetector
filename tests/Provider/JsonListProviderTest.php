<?php
/**
 * Created by Two Developers - Sven Motz und Jens Averkamp GbR
 * http://www.two-developers.com
 *
 * Author: Jens Averkamp
 */

namespace TwoDevs\ReferrerSpamDetector\Tests\Provider;


use TwoDevs\ReferrerSpamDetector\Provider\JsonListProvider;

class JsonListProviderTest extends AbstractProviderTest
{
    /**
     * @covers TwoDevs\ReferrerSpamDetector\Provider\JsonListProvider::isSpamReferrer
     */
    public function testIsSpamReferrer()
    {
        $provider = new JsonListProvider(__DIR__.'/../Fixtures/blocked.json');
        $this->runProviderTest($provider);
    }
}
