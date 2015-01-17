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
 * Common logic for providers
 */
abstract class AbstractProvider implements ProviderInterface
{

	/**
	 * Stores the provider's config.
	 * @var array
	 */
	protected $config = [];

	/**
	 * Stores any default values for the config.
	 * @var array
	 */
	protected $configDefaults = [];

	/**
	 * {@inheritdoc}
	 */
	public function setConfig(array $config)
	{
		$this->config = $config;
	}

	/**
	 * Gets the given config key, will load from config defaults if not set or return
	 * null if there is no default.
	 *
	 * @param string|int $key
	 *
	 * @return string
	 */
	public function getConfig($key = null)
	{
		if ($key === null)
		{
			return array_merge($this->configDefaults, $this->config);
		}
		elseif (isset($this->config[$key]))
		{
			return $this->config[$key];
		}
		elseif (isset($this->configDefaults[$key]))
		{
			return $this->configDefaults[$key];
		}

		return null;
	}

}
