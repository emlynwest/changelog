<?php
/**
 * @category Library
 * @license MIT http://opensource.org/licenses/MIT
 * @link https://github.com/emlynwest/changelog
 */

namespace ChangeLog\IO;

use ChangeLog\AbstractIO;
use InvalidArgumentException;
use Milo\Github\Api;
use Milo\Github\OAuth\Token;

abstract class AbstractGitHubIO extends AbstractIO
{

	/**
	 * @var Api
	 */
	protected $api;

	/**
	 * Gets an active connection to the GitHub api.
	 *
	 * @return Api
	 */
	protected function getApi()
	{
		if ($this->api === null)
		{
			$this->createApiInstance();
		}

		return $this->api;
	}

	/**
	 * Creates a new instance of the API library to use later.
	 *
	 * @throws InvalidArgumentException
	 */
	protected function createApiInstance()
	{
		$configToken = $this->getConfig('token');

		if ($configToken === null)
		{
			throw new InvalidArgumentException('API token has not been set in the config.');
		}

		$token = new Token($configToken);
		$this->api = new Api();
		$this->api->setToken($token);
	}

}
