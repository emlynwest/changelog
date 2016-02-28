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

return [
	'input' => [
		'strategy' => 'File',
		'config' => [
			'file' => 'CHANGELOG.md',
		],
	],
	'parser' => [
		'strategy' => 'KeepAChangeLog',
	],
	'renderer' => [
		'strategy' => 'KeepAChangeLog',
	],
	'output' => [
		'strategy' => 'File',
		'config' => [
			'file' => 'CHANGELOG.updated.md',
		],
	],
];
