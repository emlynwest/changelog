ChangeLog
=========

![Travis Build](https://img.shields.io/travis/stevewest/changelog.svg?style=flat-square)
![Code Coverage](https://img.shields.io/scrutinizer/g/stevewest/changelog.svg?style=flat-square)
![Code Quality](https://img.shields.io/scrutinizer/g/stevewest/changelog.svg?style=flat-square)
![HHVM](https://img.shields.io/hhvm/stevewest/changelog.svg?style=flat-square)

Package to enable change logs to be parsed into objects for manipulation in code.

Eventually the package will be able to read changelogs from a number of sources, be
able to convert those to an object structure to allow them to be modified easily and
then written out to a configured output. The output could be to a file on disk or
committed to a git repo.

Everything will be "driver" based so multiple sources, parsers and outputs can be
used as desired.
