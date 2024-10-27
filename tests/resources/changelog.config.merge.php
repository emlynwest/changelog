<?php
/**
 * @category Library
 * @license MIT http://opensource.org/licenses/MIT
 * @see https://github.com/emlynwest/changelog
 *
 * Sample config.
 */

return [
	'input' => [
		'default' => [
			'strategy' => 'File',
			'config' => [
				'file' => __DIR__.'/changelog.no_unreleased.md',
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
			'strategy' => 'json',
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
