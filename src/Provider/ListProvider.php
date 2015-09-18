<?php
/**
 * Created by Two Developers - Sven Motz und Jens Averkamp GbR
 * http://www.two-developers.com
 *
 * Author: Jens Averkamp
 */

namespace TwoDevs\ReferrerSpamDetector\Provider;

use Pdp\Uri\Url;

class ListProvider implements ProviderInterface
{
    protected $domains = array();

    /**
     * @param array $domains
     */
    public function __construct(array $domains)
    {
        $this->domains = $domains;
    }

    /**
     * {@inheritdoc}
     */
    public function isSpamReferrer(Url $url)
    {
        $url = $url->toArray();

        if (!isset($url['registerableDomain'], $url['host'], $url['publicSuffix'])) {
            return false;
        }

        foreach ($this->domains as $domain) {
            if (in_array($domain, [$url['registerableDomain'], $url['host'], $url['publicSuffix']])) {
                return true;
            }
        }

        return true;
    }
}
