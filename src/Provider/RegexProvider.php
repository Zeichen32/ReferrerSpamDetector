<?php
/**
 * Created by Two Developers - Sven Motz und Jens Averkamp GbR
 * http://www.two-developers.com
 *
 * Author: Jens Averkamp
 */

namespace TwoDevs\ReferrerSpamDetector\Provider;

use Pdp\Uri\Url;
use RegexGuard\Factory;
use RegexGuard\Interfaces\RegexRuntimeInterface;

class RegexProvider implements ProviderInterface
{
    protected $pattern;

    /** @var RegexRuntimeInterface */
    protected $regexGuard;

    /**
     * @param string                $pattern
     * @param RegexRuntimeInterface $regexGuard
     */
    public function __construct($pattern, RegexRuntimeInterface $regexGuard = null)
    {
        $this->pattern = $pattern;
        $this->regexGuard = $regexGuard ?: Factory::getGuard();
        $this->validateRegex($this->pattern);
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

        return (
            $this->regexGuard->match($this->pattern, $url['registerableDomain']) ||
            $this->regexGuard->match($this->pattern, $url['host']) ||
            $this->regexGuard->match($this->pattern, $url['publicSuffix'])
        );
    }

    protected function validateRegex($pattern)
    {
        $this->regexGuard->validateRegexOrFail($pattern);
    }
}
