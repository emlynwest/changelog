# Change Log

## [Unreleased]
### Changed
 - Changed my mind and bumped min PHP version to 8.2 [#28](https://github.com/emlynwest/changelog/issues/28)
 - Converted CI to use GitHub actions [#29](https://github.com/emlynwest/changelog/issues/29)
 - Raised minimum php version to 8.1 + bare minimum code updates [#28](https://github.com/emlynwest/changelog/issues/28)
 - Updated composer packages to run with 8.1+ versions of packages [#28](https://github.com/emlynwest/changelog/issues/28)
 - Updated composer packages and fixed tests to run on 8.1 [#28](https://github.com/emlynwest/changelog/issues/28)

## [1.3.0]
### Added
- Introduce command line merge command [#25](https://github.com/emlynwest/changelog/issues/25)
- Build targets for PHP 7.1 and 7.2

### Removed
- Build target for HHVM

## [1.2.0] 2016-04-23
### Added
- Create release command line utility [#6](https://github.com/emlynwest/changelog/issues/6).
- Create convert command line utility [#6](https://github.com/emlynwest/changelog/issues/6).
- Create add command line utility [#6](https://github.com/emlynwest/changelog/issues/6).
- Task to create .phar distributable.

### Fixed
- Links are no longer parsed as a description.
- Links are now parsed correctly.
- No longer require `dev-master` for the `naneau/semver` package [#21](https://github.com/emlynwest/changelog/issues/21).

## [1.1.0]
### Added
- Flysystem IO adaptor [#3](https://github.com/emlynwest/changelog/issues/3).
- GitHub release reading as part of [#17](https://github.com/emlynwest/changelog/issues/17).

### Fixed
- Fixes `KeepAChangeLog` behaving strangely with extra new lines [#19](https://github.com/emlynwest/changelog/issues/19).
- Changed `IO\String` to `IO\Native`

## [1.0.0]
### Removed
- `IO\File` no longer does an `is_file()` check to allow for remote url fetching [#13](https://github.com/emlynwest/changelog/issues/13).

## [0.4.0] - 2015-01-29
### Added
- Remove a `Release` from a `Log` [#14](https://github.com/emlynwest/changelog/issues/14).
- Added date field to `Release` and date parsing to `KeepAChangeLog` parser [#11](https://github.com/emlynwest/changelog/issues/11).
- Added support to `KeepAChangeLog` to look for yanked releases [#10](https://github.com/emlynwest/changelog/issues/10).
- Added messy link handling to `KeepAChangeLog` [#9](https://github.com/emlynwest/changelog/issues/9).
- Json and XML renderer [#7](https://github.com/emlynwest/changelog/issues/7).

### Fixed
- Fixed sorting releases with a release of the title "unreleased" [#15](https://github.com/emlynwest/changelog/issues/15).
- Named links are now parsed and rendered correctly.

### Changed
- Splits `Parser` into `Renderer`s and `Parser`s to better separate the functionality.

## [0.3.0] - 2015-01-25
### Added
- `Release`s are now sorted when being added to a `Log` [#12](https://github.com/emlynwest/changelog/issues/12).
- `Log`s can now be merged [#5](https://github.com/emlynwest/changelog/issues/5).
- GitHub IO adaptor implemented [#4](https://github.com/emlynwest/changelog/issues/4).

### Changed
- `ChangeLog` now throws exceptions if input/output are not set when calling `parse()` and `write()`.

## [0.2.0] - 2015-01-21
### Added
- Implements array access for `Log` [#1](https://github.com/emlynwest/changelog/issues/1).
- Added name param to Release constructor.
- Added ability to write out logs to file [#2](https://github.com/emlynwest/changelog/issues/2).

### Changed
- Renamed "providers" to "IO".

## [0.1.0] - 2015-01-18
### Added
- Initial version.

[Unreleased]: https://github.com/emlynwest/changelog
[1.3.0]: https://github.com/emlynwest/changelog/releases/tag/1.3.0
[1.2.0]: https://github.com/emlynwest/changelog/releases/tag/1.2.0
[1.1.0]: https://github.com/emlynwest/changelog/releases/tag/1.1.0
[1.0.0]: https://github.com/emlynwest/changelog/releases/tag/1.0.0
[0.4.0]: https://github.com/emlynwest/changelog/releases/tag/0.4.0
[0.3.0]: https://github.com/emlynwest/changelog/releases/tag/0.3.0
[0.2.0]: https://github.com/emlynwest/changelog/releases/tag/0.2.0
[0.1.0]: https://github.com/emlynwest/changelog/releases/tag/0.1.0
