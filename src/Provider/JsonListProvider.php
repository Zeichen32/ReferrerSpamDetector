<?php
/**
 * Created by Two Developers - Sven Motz und Jens Averkamp GbR
 * http://www.two-developers.com
 *
 * Author: Jens Averkamp
 */

namespace TwoDevs\ReferrerSpamDetector\Provider;

use Pdp\Uri\Url;

class JsonListProvider implements ProviderInterface
{
    /** @var string */
    protected $file;

    /** @var array */
    protected $loadedDomains = array();

    /**
     * @param string $file
     */
    public function __construct($file)
    {
        if (!is_readable($file)) {
            throw new \RuntimeException(sprintf('Cannot open file "%s"', $file));
        }

        $this->file = $file;
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

        if (!count($this->loadedDomains)) {
            $this->loadedDomains = @json_decode(file_get_contents($this->file), true);
            if (!is_array($this->loadedDomains)) {
                $this->loadedDomains = array();
            }
        }

        foreach ($this->loadedDomains as $domain) {
            if (in_array($domain, [$url['registerableDomain'], $url['host'], $url['publicSuffix']])) {
                return true;
            }
        }

        return false;
    }
}
