<?php
/**
 * Created by Two Developers - Sven Motz und Jens Averkamp GbR
 * http://www.two-developers.com
 *
 * Author: Jens Averkamp
 */

namespace TwoDevs\ReferrerSpamDetector\Tests\Provider;


use TwoDevs\ReferrerSpamDetector\Provider\TxtListProvider;

class TxtListProviderTest extends AbstractProviderTest
{
    /**
     * @covers TwoDevs\ReferrerSpamDetector\Provider\TxtListProvider::isSpamReferrer
     */
    public function testIsSpamReferrer()
    {
        $provider = new TxtListProvider(__DIR__.'/../Fixtures/blocked.txt');
        $this->runProviderTest($provider);
    }
}
