<?php
/**
 * PHP Version 5.5
 * @category Library
 * @package ChangeLog
 * @author Steve "uru" West <steve.david.west@gmail.com>
 * @license MIT http://opensource.org/licenses/MIT
 * @link https://github.com/stevewest/changelog
 */

namespace ChangeLog;

/**
 * Provides a common interface for reading change logs from various locations.
 */
interface IOInterface
{

	/**
	 * Sets the provider's config.
	 * See individual providers for the needed keys.
	 *
	 * @param array $config
	 *
	 * @return void
	 */
	public function setConfig($config);

	/**
	 * Returns the content of the change log to be parsed.
	 * The returned data should be an array of strings, one entry for each file line.
	 *
	 * @return array
	 */
	public function getContent();

	/**
	 * Writes out the given content,
	 *
	 * @param string $content
	 */
	public function setContent($content);

}
