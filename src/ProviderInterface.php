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
interface ProviderInterface
{

	/**
	 * Sets the provider's config.
	 * See individual providers for the needed keys.
	 *
	 * @param array $config
	 *
	 * @return void
	 */
	public function setConfig(array $config);

	/**
	 * Returns the next available line of the change log or null if there is no more
	 * content.
	 *
	 * @return string|null
	 */
	public function nextLine();

}
