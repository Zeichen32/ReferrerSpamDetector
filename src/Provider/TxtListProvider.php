<?php
/**
 * Created by Two Developers - Sven Motz und Jens Averkamp GbR
 * http://www.two-developers.com
 *
 * Author: Jens Averkamp
 */

namespace TwoDevs\ReferrerSpamDetector\Provider;

use Pdp\Uri\Url;

class TxtListProvider implements ProviderInterface
{
    /** @var string */
    protected $file;

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

        $f = fopen($this->file, 'r');
        while (!feof($f)) {
            $domain = trim(fgets($f));
            if (in_array($domain, [$url['registerableDomain'], $url['host'], $url['publicSuffix']])) {
                fclose($f);

                return true;
            }
        }

        fclose($f);

        return false;
    }
}
