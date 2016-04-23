<?php
/**
 * PHP Version 5.6
 * @category Library
 * @package ChangeLog
 * @author Steve "uru" West <steven.david.west@gmail.com>
 * @license MIT http://opensource.org/licenses/MIT
 * @link https://github.com/stevewest/changelog
 *
 * Sample config.
 */

/**
 * Sample config for the command line utility
 * TODO: expand this out to cover all the various IO, parser and renderer options
 */

return [
	'input' => [
		'default' => [
			'strategy' => 'File',
			'config' => [
				'file' => 'CHANGELOG.md',
			],
		],
	],
	'parser' => [
		'default' => [
			'strategy' => 'KeepAChangeLog',
		],
	],
	'renderer' => [
		'default' => [
			'strategy' => 'KeepAChangeLog',
		],
		'json' => [
			'strategy' => 'Json',
		],
	],
	'output' => [
		'default' => [
			'strategy' => 'File',
			'config' => [
				'file' => 'CHANGELOG.updated.md',
			],
		],
	],
];
