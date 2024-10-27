<?php
/**
 * @category Library
 * @license MIT http://opensource.org/licenses/MIT
 * @link https://github.com/emlynwest/changelog
 */

namespace ChangeLog\IO;

use ChangeLog\Stub\GitHubStub;
use Codeception\Test\Unit;
use InvalidArgumentException;
use Mockery;
use stdClass;

/**
 * Tests for IO\GitHub
 */
class GitHubTest extends Unit
{

	public function testGetContent()
	{
		$repo = 'foo/bar';
		$file = 'changelog.md';

		$apiMock = Mockery::mock();
		$apiMock->shouldReceive('get')
			->with("/repos/$repo/contents/$file")
			->andReturn(true)
			->once();

		$expected = new stdClass;
		$content = 'foobar';
		$expected->content = base64_encode($content);

		$apiMock->shouldReceive('decode')
			->with(true)
			->andReturn($expected)
			->once();

		$gitHub = new GitHubStub;
		$gitHub->setApi($apiMock);
		$gitHub->setConfig([
			'repo' => $repo,
			'file' => $file,
		]);

		$this->assertEquals(
			[$content],
			$gitHub->getContent()
		);
	}

	public function testCreateApiWithNoToken()
	{
		$this->expectException(InvalidArgumentException::class);

		$gitHub = new GitHubStub;
		$gitHub->getContent();
	}

	public function testSetContent()
	{
		$repo = 'foo/bar';
		$file = 'changelog.md';
		$path = "/repos/$repo/contents/$file";
		$message = 'I updated the changelog!';
		$newContent = 'foobarmazbat';

		$apiMock = Mockery::mock();
		$apiMock->shouldReceive('get')
			->with($path)
			->andReturn(true)
			->once();

		$expected = new stdClass;
		$content = 'foobar';
		$sha = 'asdasd';
		$expected->sha = $sha;
		$expected->content = base64_encode($content);

		$apiMock->shouldReceive('decode')
			->with(true)
			->andReturn($expected)
			->twice();

		$apiMock->shouldReceive('put')
			->with($path, [
				'message' => $message,
				'content' => base64_encode($newContent),
				'sha' => $sha,
			])
			->andReturn(true)
			->once();

		$gitHub = new GitHubStub;
		$gitHub->setApi($apiMock);
		$gitHub->setConfig([
			'repo' => $repo,
			'file' => $file,
			'commit_message' => $message,
		]);

		$gitHub->setContent($newContent);
	}

}
