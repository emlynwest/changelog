# ChangeLog

TODO: New build badge
[![Build Status](https://github.com/emlynwest/changelog/actions/workflows/main.yml/badge.svg)](https://github.com/emlynwest/changelog/actions)
[![Code Coverage](https://img.shields.io/scrutinizer/g/emlynwest/changelog.svg?style=flat-square)](https://scrutinizer-ci.com/g/emlynwest/changelog/)
[![Code Quality](https://img.shields.io/scrutinizer/coverage/g/emlynwest/changelog.svg?style=flat-square)](https://scrutinizer-ci.com/g/emlynwest/changelog/)
[![Packagist](https://img.shields.io/packagist/v/emlynwest/changelog.svg?style=flat-square)](https://packagist.org/packages/emlynwest/changelog)

Quickly and easily modify change logs from a variety of sources.

Currently the package only supports the [KeepAChangeLog] format of change logs.

It is possible to read and write logs from/to:

 - File
 - Url (no support for output)
 - Native string
 - [Flysystem][flysystem]
 - GitHub repo via GitHub API (currently not for output as I've yet to find a sensible way to do this)

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

**Note** releases are sorted in accordance to [Semantic Versioning](http://semver.org) automatically with the latest release at the top.
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

## Command line utility

Common actions can be performed from the command line using the `./vendor/bin/changelog` command or via the `changelog.phar`
at [the releases page][releases].

The command line utility expects a config file called `changelog.config.php` to exist in the working directory, or it
can be specified with the global `--config` option. An example config file can be found in `changelog.config.example.php`

All commands use the same four options to read, parse, render and finally output a change log. These all default to the
"default" entry in their respective config arrays.

```
      --input[=INPUT]        Config to use for input processor [default: "default"]
      --parser[=PARSER]      Config to use for parser processor [default: "default"]
      --renderer[=RENDERER]  Config to use for renderer processor [default: "default"]
      --output[=OUTPUT]      Config to use for output processor [default: "default"]
```

Eg: `changelog.phar --renderer=json` would use the `json` entry from the `renderer` entry of the config file to construct
a `ChangeLog\Renderer\Json` object to use to create the end content.

The current commands are:
 - Add: Adds a change to a release
 - Convert:  Converts a release between formats. Simply runs the read, parse, render, write sequence.
 - Release: Converts the "unreleased" release into a real release. Can take names such as `major`, `minor`, `patch` to
 automatically create release numbers.
 - Merge: Merge multiple changelog into one.

Check `changelog.phar help` for more information.

## Development

Current plans for development can be found in the repo's [issue tracker][issues].
If you wish to request extra functionality then open an issue or pull request.

Feel free to report any issues on the [issue tracker][issues].

## Author

### Emlyn West

 - [GitHub]
 - Email: emlyn.west@gmail.com

[KeepAChangeLog]: http://keepachangelog.com/
[flysystem]: http://flysystem.thephpleague.com/
[issues]: https://github.com/emlynwest/changelog/issues
[GitHub]: https://github.com/emlynwest
[releases]: https://github.com/emlynwest/changelog/releases
