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
		'default' => [
			'strategy' => 'File',
			'config' => [
				'file' => __DIR__.'/changelog.md',
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
			'strategy' => 'Json',
		],
	],
	'output' => [
		'default' => [
			'strategy' => 'File',
			'config' => [
				'file' => __DIR__.'/../_output/changelog.json',
			],
		],
	],
];
