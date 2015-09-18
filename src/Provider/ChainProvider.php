<?php
/**
 * Created by Two Developers - Sven Motz und Jens Averkamp GbR
 * http://www.two-developers.com
 *
 * Author: Jens Averkamp
 */

namespace TwoDevs\ReferrerSpamDetector\Provider;

use Pdp\Uri\Url;

class ChainProvider implements ProviderInterface
{
    /** @var ProviderInterface[] */
    protected $providers;

    /** @var array */
    protected $cachedDomains = array();

    /**
     * @param ProviderInterface[] $providers
     */
    public function __construct(array $providers)
    {
        $this->providers = new \SplObjectStorage();

        foreach ($providers as $provider) {
            if (!$provider instanceof ProviderInterface) {
                throw new \RuntimeException(sprintf('"%s" is not a valid provder!', get_class($provider)));
            }

            $this->providers->attach($provider);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function isSpamReferrer(Url $url)
    {
        if (in_array((string) $url, $this->cachedDomains)) {
            return true;
        }

        foreach ($this->providers as $provider) {
            if (true === $provider->isSpamReferrer($url)) {
                $this->cachedDomains[] = (string) $url;

                return true;
            }
        }

        return false;
    }
}
