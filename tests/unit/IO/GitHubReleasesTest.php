<?php
/**
 * @category Library
 * @license MIT http://opensource.org/licenses/MIT
 * @link https://github.com/emlynwest/changelog
 */

namespace ChangeLog\IO;

use ChangeLog\Stub\GitHubReleasesStub;
use Codeception\Test\Unit;
use Exception;
use Mockery;
use stdClass;

/**
 * Tests for IO\GitHubReleases
 */
class GitHubReleasesTest extends Unit
{

	public function testGetContent()
	{
		$repo = 'foo/bar';

		$apiMock = Mockery::mock();
		$apiMock->shouldReceive('get')
			->with("/repos/$repo/releases")
			->andReturn(true)
			->once();

		$release1 = new stdClass;
		$release1->published_at = '2015-02-26';
		$release1->tag_name = '0.2.0';
		$release1->body = 'content 2';
		$release1->html_url = 'http://release.com/2';

		$release2 = new stdClass;
		$release2->published_at = '2015-02-25';
		$release2->tag_name = '0.1.0';
		$release2->body = 'content 1';
		$release2->html_url = 'http://release.com/1';

		$releases = [$release1, $release2];

		$apiMock->shouldReceive('decode')
			->with(true)
			->andReturn($releases)
			->once();

		$gitHub = new GitHubReleasesStub;
		$gitHub->setApi($apiMock);
		$gitHub->setConfig([
			'repo' => $repo,
		]);

		$this->assertEquals(
			[
				'# GitHub Releases',
				'',
				'## [0.2.0] - 2015-02-26',
				'content 2',
				'## [0.1.0] - 2015-02-25',
				'content 1',
				'',
				'[0.2.0]: http://release.com/2',
				'[0.1.0]: http://release.com/1',
			],
			$gitHub->getContent()
		);
	}

	public function testSetContent()
	{
		$this->expectException(Exception::class);
		$this->expectExceptionMessage('This has yet to be implemented.');

		$gitHub = new GitHubReleasesStub;
		$gitHub->setContent('foobar');
	}

}
