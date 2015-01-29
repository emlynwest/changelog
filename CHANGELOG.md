# Change Log

## [Unreleased]
### Added
- Remove a `Release` from a `Log` [#14](https://github.com/stevewest/changelog/issues/14).
- Added date field to `Release` and date parsing to `KeepAChangeLog` parser [#11](https://github.com/stevewest/changelog/issues/11).
- Added support to `KeepAChangeLog` to look for yanked releases [#10](https://github.com/stevewest/changelog/issues/10).
- Added messy link handling to `KeepAChangeLog` [#9](https://github.com/stevewest/changelog/issues/9).

### Fixed
- Fixed sorting releases with a release of the title "unreleased [#15](https://github.com/stevewest/changelog/issues/15).

## [0.3.0] - 2015-01-25
### Added
- `Release`s are now sorted when being added to a `Log` [#12](https://github.com/stevewest/changelog/issues/12).
- `Log`s can now be merged [#5](https://github.com/stevewest/changelog/issues/5).
- GitHub IO adaptor implemented [#4](https://github.com/stevewest/changelog/issues/4).

### Changed
- `ChangeLog` now throws exceptions if input/output are not set when calling `parse()` and `write()`.

## [0.2.0] - 2015-01-21
### Added
- Implements array access for `Log` [#1](https://github.com/stevewest/changelog/issues/1).
- Added name param to Release constructor.
- Added ability to write out logs to file [#2](https://github.com/stevewest/changelog/issues/2).

### Changed
- Renamed "providers" to "IO".

## [0.1.0] - 2015-01-18
### Added
- Initial version.

[Unreleased]: https://github.com/stevewest/changelog
[0.3.0]: https://github.com/stevewest/changelog/releases/tag/0.3.0
[0.2.0]: https://github.com/stevewest/changelog/releases/tag/0.2.0
[0.1.0]: https://github.com/stevewest/changelog/releases/tag/0.1.0
