# ChangeLog

[![Travis Build](https://img.shields.io/travis/stevewest/changelog.svg?style=flat-square)](https://travis-ci.org/stevewest/changelog/)
[![Code Coverage](https://img.shields.io/scrutinizer/g/stevewest/changelog.svg?style=flat-square)](https://scrutinizer-ci.com/g/stevewest/changelog/)
[![Code Quality](https://img.shields.io/scrutinizer/coverage/g/stevewest/changelog.svg?style=flat-square)](https://scrutinizer-ci.com/g/stevewest/changelog/)
[![HHVM](https://img.shields.io/hhvm/stevewest/changelog.svg?style=flat-square)](http://hhvm.h4cc.de/package/stevewest/changelog)
[![Packagist](https://img.shields.io/packagist/v/stevewest/changelog.svg?style=flat-square)](https://packagist.org/packages/stevewest/changelog)

Package to enable change logs to be parsed into objects for manipulation in code.

Eventually the package will be able to read change logs from a number of sources, be
able to convert those to an object structure to allow them to be modified easily and
then written out to a configured output. The output could be to a file on disk or
committed to a git repo.

Everything is adaptor/driver based so multiple sources, parsers and outputs can be
used as desired. There are also plans for a cli script.

## Quick Examples

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
