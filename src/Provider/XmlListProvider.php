<?php
/**
 * Created by Two Developers - Sven Motz und Jens Averkamp GbR
 * http://www.two-developers.com
 *
 * Author: Jens Averkamp
 */

namespace TwoDevs\ReferrerSpamDetector\Provider;

use Pdp\Uri\Url;
use Prewk\XmlStringStreamer;
use Prewk\XmlStringStreamer\Stream\File;

class XmlListProvider implements ProviderInterface
{
    /** @var string */
    protected $file;

    /**
     * @param string $file
     */
    public function __construct($file)
    {
        if (!is_file($file) || !is_readable($file)) {
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

        $provider = new File($this->file, 1024);
        $parser = new XmlStringStreamer\Parser\StringWalker();
        $streamer = new XmlStringStreamer($parser, $provider);

        while ($node = $streamer->getNode()) {
            $domain = (string) simplexml_load_string($node);

            if (in_array($domain, [$url['registerableDomain'], $url['host'], $url['publicSuffix']])) {
                return true;
            }
        }

        return false;
    }
}
