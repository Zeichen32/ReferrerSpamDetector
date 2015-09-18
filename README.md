ReferrerSpam Detector
==============

Referrer spam (also known as log spam or referrer bombing) is a kind of spamming aimed at web analytics tools. 
A spammer bot makes repeated web site requests using a fake referrer URL to the site the spammer wishes to advertise.

# How to use?

## composer setup

This is the easiest method, but requires the use of [Composer](http://getcomposer.org). Add ReferrerSpamDetector to your
project by running the following in your terminal:

```shell
composer require twodevs/referrer-spam-detector
```

## Get a blocklist

This library will not provide any blocklist, but many list are online available:

- [piwik/referrer-spam-blacklist](https://raw.githubusercontent.com/piwik/referrer-spam-blacklist/master/spammers.txt)
- [Stevie-Ray/htaccess-referral-spam-blacklist-block](https://raw.githubusercontent.com/Stevie-Ray/htaccess-referral-spam-blacklist-block/master/.htaccess)
- [antispam/false-referrals](https://raw.githubusercontent.com/antispam/false-referrals/master/false-referrals.txt)
- [nabble/semalt-blocker](https://raw.githubusercontent.com/nabble/semalt-blocker/master/domains/blocked)

Download one or more list into you project directory.

## Create a ReferrerDetector
There are multiple Providers available:

- [ListProvider](https://github.com/Zeichen32/ReferrerSpamDetector/master/src/Provider/ListProvider.php)
- [TxtListProvider](https://github.com/Zeichen32/ReferrerSpamDetector/master/src/Provider/TxtListProvider.php)
- [CsvListProvider](https://github.com/Zeichen32/ReferrerSpamDetector/master/src/Provider/CsvListProvider.php)
- [XmlListProvider](https://github.com/Zeichen32/ReferrerSpamDetector/master/src/Provider/XmlListProvider.php)
- [RegexProvider](https://github.com/Zeichen32/ReferrerSpamDetector/master/src/Provider/RegexProvider.php)
- [PdoProvider](https://github.com/Zeichen32/ReferrerSpamDetector/master/src/Provider/PdoProvider.php)

### Basic example
```php
// DomainParser
$pslManager = new Pdp\PublicSuffixListManager();
$parser = new Pdp\Parser($pslManager->getList());

// Referrer Provider
$provider = new \TwoDevs\ReferrerSpamDetector\Provider\TxtListProvider(__DIR__.'/data/blocked.txt');

// Create detector
$detector = new \TwoDevs\ReferrerSpamDetector\ReferrerDetector($provider, $parser);


// Mock Referrer - Remove this line in production environment
$_SERVER['HTTP_REFERER'] = 'http://example.org/index.php?id=3';

$referrer = !empty($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
var_dump($detector->isSpamReferrer($referrer));
```

### Multiple Provider at once
```php
// DomainParser
$pslManager = new Pdp\PublicSuffixListManager();
$parser = new Pdp\Parser($pslManager->getList());

// Create as many provider as you want
$provider = new \TwoDevs\ReferrerSpamDetector\Provider\ChainProvider(array(
    new \TwoDevs\ReferrerSpamDetector\Provider\TxtListProvider(__DIR__.'/data/blocked.txt'),
    new \TwoDevs\ReferrerSpamDetector\Provider\JsonListProvider(__DIR__.'/data/blocked.json'),
));

// Create detector
$detector = new \TwoDevs\ReferrerSpamDetector\ReferrerDetector($provider, $parser);


// Mock Referrer - Remove this line in production environment
$_SERVER['HTTP_REFERER'] = 'http://dev.example.org/index.php?id=3';

$referrer = !empty($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
var_dump($detector->isSpamReferrer($referrer));
```

# contribute

Yes, please! Feel free to open issues or pull-requests.

# licence

MIT