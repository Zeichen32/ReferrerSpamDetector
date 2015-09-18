<?php
/**
 * Created by Two Developers - Sven Motz und Jens Averkamp GbR
 * http://www.two-developers.com
 *
 * Author: Jens Averkamp
 */

namespace TwoDevs\ReferrerSpamDetector;

use Pdp\Parser;
use Pdp\Uri\Url;
use TwoDevs\ReferrerSpamDetector\Provider\ProviderInterface;

class ReferrerDetector
{
    /** @var ProviderInterface */
    protected $provider;

    /** @var Parser */
    protected $domainParser;

    /**
     * @param ProviderInterface $provider
     * @param Parser            $domainParser
     */
    public function __construct(ProviderInterface $provider, Parser $domainParser)
    {
        $this->provider = $provider;
        $this->domainParser = $domainParser;
    }

    /**
     * @param string|Url $url
     * @return bool
     */
    public function isSpamReferrer($url)
    {
        if (!$url instanceof Url) {
            try {
                $url = $this->domainParser->parseUrl($url);
            } catch (\Exception $exp) {
                return false;
            }
        }

        return $this->provider->isSpamReferrer($url);
    }
}
