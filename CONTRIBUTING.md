# Contributing

Contributions are awesome but to help things along please take a look at the following.

 - [Issues](#-issues)
 - [Feature Requests](#-feature-requests)
 - [Pull Requests](#-pull-requests)

## Issues

When opening an issue please make sure to include as much information as possible such as:

 - **things you have already tried**
 - Have you tried the latest package version? (`dev-main`)
 - Is there already a similar issue?
 - PHP version
 - Stack trace
 - Sample code or data

## Feature requests

Feature requests can be either opened as an issue or you can contact me and ask for something.

When you do think about what you are asking for, will others use it? Is it specific to your problem or not?

## Pull requests

These are always welcome, it's what open source software is all about. But please keep a few things in mind:

### Follow the coding standard

This package uses [PSR-2] with the exception that indentation should be `tab` characters, not `spaces` and that all `{`
should be on a new line.

### Unit tests

Any changes to the code should include updated or additional tests.
Please make sure that if a test relates to an issue there is an `@link` to show that.

Any new features should have related tests in the same pull request.

All tests must pass, nothing will be merged in if there are tests failing.

### Code Quality

While mostly a secondary concern code quality is still important. As a general rule of thumb make sure methods are not
too long or needlessly complex when they can be broken up, use a bit of common sense.

[PSR-2]: http://www.php-fig.org/psr/psr-2/
