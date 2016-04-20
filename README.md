# ChangeLog

[![Travis Build](https://img.shields.io/travis/stevewest/changelog.svg?style=flat-square)](https://travis-ci.org/stevewest/changelog/)
[![Code Coverage](https://img.shields.io/scrutinizer/g/stevewest/changelog.svg?style=flat-square)](https://scrutinizer-ci.com/g/stevewest/changelog/)
[![Code Quality](https://img.shields.io/scrutinizer/coverage/g/stevewest/changelog.svg?style=flat-square)](https://scrutinizer-ci.com/g/stevewest/changelog/)
[![PHP 7 ready](http://php7ready.timesplinter.ch/stevewest/changelog/badge.svg)](https://travis-ci.org/stevewest/changelog)
[![HHVM](https://img.shields.io/hhvm/stevewest/changelog.svg?style=flat-square)](http://hhvm.h4cc.de/package/stevewest/changelog)
[![Packagist](https://img.shields.io/packagist/v/stevewest/changelog.svg?style=flat-square)](https://packagist.org/packages/stevewest/changelog)

Quickly and easily modify change logs from a variety of sources.

Currently the package only supports the [KeepAChangeLog] format of change logs.

It is possible to read and write logs from/to:

 - File
 - Url (no support for output)
 - Native string
 - [Flysystem][flysystem]
 - GitHub repo via GitHub API

Logs can be formatted into the [KeepAChangeLog] format, xml and json through the use of various render classes.

## Quick Examples

### Creating a log

```php
<?php

// Create a new change log and set a title and description.
$log = new \ChangeLog\Log();
$log->setTitle('My Project Change Log');
$log->setDescription('This is my project\'s change log. Any crazy stuff that happens will appear here.');

// Create and add a new release.
$release1 = new \ChangeLog\Release('1.0.0');
$release1->addChange('Added', 'Awesome feature needed for release');
$log->addRelease($release1);

$release2 = new \ChangeLog\Release('0.3.0');
$release2->addChange('Added', 'Finally added a change log');
$release2->setChanges('Fixed', [
	'Bug 1',
	'Bug 2',
	'Bug 3',
]);
$log->addRelease($release2);
```

**Note** releases are sorted in accordance to semantic visioning automatically with the latest release at the top.
It is expected that all release names follow this and the only exception to this is `unreleased` which will always be at
the top of the release list.

### Parsing a log

```php
<?php

$input = new \ChangeLog\IO\File([
	'file' => 'path/to/changelog.md'
]);

$parser = new \ChangeLog\Parser\KeepAChangeLog();

$cl = new \ChangeLog\ChangeLog;
$cl->setParser($parser);
$cl->setInput($input);

$log = $cl->parse();

// Instance of ChangeLog\Log
var_dump($log);
```

### Writing a log

```php
<?php

$output = new \ChangeLog\IO\File([
	'file' => 'path/to/changelog.md'
]);

$renderer = new \ChangeLog\Renderer\KeepAChangeLog();

$cl = new \ChangeLog\ChangeLog;
$cl->setRenderer($renderer);
$cl->setOutput($output);

$log = new Log;
// Build up the log file information here

$cl->write($log);
```

### Merging Logs

Logs can be merged together to create a single change log. This includes releases and their changes.

```php
$log1 = new Log;
// Add some releases or something

$log2 = new Log;
// Add some releases to this too

$log1->mergeLog($log2);
// $log1 now contains all releases and changes from $log2
```

Depending on your use case it might be useful to create an empty log first and merge other logs into that.

## Development

Current plans for development can be found in the repo's [issue tracker][issues].
If you wish to request extra functionality then open an issue or pull request or give me a poke on [twitter] or anywhere
else you can find me.

Feel free to report any issues on the [issue tracker][issues].

## Author

### Steve "uru" West

 - [Twitter][twitter]
 - [GitHub]
 - Email: steven.david.west@gmail.com

[KeepAChangeLog]: http://keepachangelog.com/
[flysystem]: http://flysystem.thephpleague.com/
[issues]: https://github.com/stevewest/changelog/issues
[twitter]: http://twitter.com/SteveUru
[GitHub]: https://github.com
