<?php
/**
 * @category Library
 * @package ChangeLog
 * @license MIT http://opensource.org/licenses/MIT
 * @link https://github.com/emlynwest/changelog
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
