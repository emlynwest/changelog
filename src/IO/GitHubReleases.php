<?php
/**
 * @category Library
 * @license MIT http://opensource.org/licenses/MIT
 * @link https://github.com/emlynwest/changelog
 */

namespace ChangeLog\IO;

/**
 * Allows change log files to be generated from the GitHub release api.
 *
 * This class has the following config options.
 * - repo: "<user>/<repo>" The full username and repo name to use.
 * - token: GitHub API token, can be generated under account -> applications.
 * - log_title: Optional name of the change log.
 *
 * The token must have the "repo" or "public_repo" permission depending on the visibility of the repo.
 */
class GitHubReleases extends AbstractGitHubIO
{

	protected $configDefaults = [
		'log_title' => 'GitHub Releases',
	];

	/**
	 * Returns the content of the change log to be parsed.
	 * The returned data should be an array of strings, one entry for each file line.
	 *
	 * @return array
	 */
	public function getContent()
	{
		$api = $this->getApi();
		$response = $api->get($this->getApiUrl());
		$content = $api->decode($response);

		$links = [];

		$title = $this->getConfig('log_title');
		$log = "# $title\n\n";

		foreach($content as $release)
		{
			// published_at for release date
			$date = substr($release->published_at, 0, 10);

			// tag_name for the release title
			$log .= "## [{$release->tag_name}] - $date\n";

			// body for the release changes
			$log .= $release->body."\n";

			// html_url for links added at the end
			$links[] = "[{$release->tag_name}]: {$release->html_url}";
		}

		return explode("\n", $log . "\n" . implode("\n", $links));
	}

	/**
	 * Writes out the given content,
	 *
	 * @param string $content
	 */
	public function setContent($content)
	{
		// TODO: Implement setContent() method.
		throw new \Exception('This has yet to be implemented.');
	}

	/**
	 * Gets a URL for the GitHub api for our file.
	 *
	 * @return string
	 */
	protected function getApiUrl()
	{
		$repo = $this->getConfig('repo');

		$url = "/repos/$repo/releases";
		return $url;
	}

}
