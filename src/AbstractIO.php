<?php
/**
 * PHP Version 5.6
 * @category Library
 * @package ChangeLog
 * @author Emlyn West <emlyn.west@gmail.gom>
 * @license MIT http://opensource.org/licenses/MIT
 * @link https://github.com/emlynwest/changelog
 */

namespace ChangeLog;

/**
 * Common logic for providers
 */
abstract class AbstractIO implements IOInterface
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
	 * @param array $config
	 */
	public function __construct($config = [])
	{
		$this->setConfig($config);
	}

	/**
	 * {@inheritdoc}
	 */
	public function setConfig($config)
	{
		$this->config = $config;
	}

	/**
	 * Gets the given config key, will load from config defaults if not set or return
	 * null if there is no default.
	 *
	 * @param string|int $key
	 *
	 * @return string|array
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
