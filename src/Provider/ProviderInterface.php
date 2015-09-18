<?php
/**
 * Created by Two Developers - Sven Motz und Jens Averkamp GbR
 * http://www.two-developers.com
 *
 * Author: Jens Averkamp
 */

namespace TwoDevs\ReferrerSpamDetector\Provider;

use Pdp\Uri\Url;

interface ProviderInterface
{
    /**
     * Checks if a url is on referrer list
     *
     * @param Url $url
     * @return bool
     */
    public function isSpamReferrer(Url $url);
}
