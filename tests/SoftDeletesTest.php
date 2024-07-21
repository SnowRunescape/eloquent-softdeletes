<?php

namespace SnowRunescape\SoftDeletes\Tests;

use Illuminate\Database\Capsule\Manager as DB;
use PHPUnit\Framework\TestCase;
use SnowRunescape\SoftDeletes\Tests\Fixtures\Post;

class SoftDeletesTest extends TestCase
{
    protected function setUp(): void
    {
        DB::table('posts')->truncate();
    }

    public function testPostCreationAndSoftDeletion()
    {
        Post::create(['title' => 'First Post', 'status' => Post::STATUS['active']]);
        Post::create(['title' => 'Second Post', 'status' => Post::STATUS['active']]);

        $this->assertEquals(2, Post::count());

        $thirdPost = Post::create(['title' => 'Third Post', 'status' => Post::STATUS['active']]);
        $this->assertEquals(3, Post::count());

        $thirdPost->delete();
        $this->assertEquals(2, Post::count());
        $this->assertEquals(3, Post::withTrashed()->count());
        $this->assertEquals(1, Post::onlyTrashed()->count());
    }

    public function testRestoreDeletedPost()
    {
        Post::create(['title' => 'First Post', 'status' => Post::STATUS['active']]);
        $deletedPost = Post::create(['title' => 'Second Post', 'status' => Post::STATUS['deleted']]);

        $this->assertEquals(1, Post::count());

        $deletedPost->restore();
        $this->assertEquals(2, Post::count());
    }

    public function testUpdateStatusToDeleted()
    {
        $post = Post::create(['title' => 'First Post', 'status' => Post::STATUS['active']]);

        $this->assertEquals(1, Post::count());

        $post->delete();
        $this->assertEquals(0, Post::count());
        $this->assertEquals(1, Post::onlyTrashed()->count());
    }

    public function testQueryIncludingSoftDeletedRecords()
    {
        Post::create(['title' => 'Active Post', 'status' => Post::STATUS['active']]);
        Post::create(['title' => 'Deleted Post', 'status' => Post::STATUS['deleted']]);

        $allPosts = Post::withTrashed()->get();
        $this->assertCount(2, $allPosts);

        $deletedPosts = Post::onlyTrashed()->get();
        $this->assertCount(1, $deletedPosts);
        $this->assertEquals('Deleted Post', $deletedPosts->first()->title);
    }
}
