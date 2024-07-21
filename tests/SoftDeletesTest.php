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

        Post::create(['title' => 'Three Post', 'status' => Post::STATUS['active']]);

        $this->assertEquals(3, Post::count());

        Post::create(['title' => 'Three Post', 'status' => Post::STATUS['deleted']]);

        $this->assertEquals(3, Post::count());
        $this->assertEquals(4, Post::withTrashed()->count());


        $this->assertEquals(1, Post::onlyTrashed()->count());
    }

    public function testRestoreDeletedPost()
    {
        Post::create(['title' => 'First Post', 'status' => Post::STATUS['active']]);
        Post::create(['title' => 'Second Post', 'status' => Post::STATUS['deleted']]);

        $this->assertEquals(1, Post::count());

        $post = Post::onlyTrashed()->first();
        $post->restore();

        $this->assertEquals(2, Post::count());
    }

    public function testUpdateStatusToDeleted()
    {
        $post = Post::create(['title' => 'First Post', 'status' => Post::STATUS['active']]);

        $this->assertEquals(1, Post::count());

        $post->delete();

        $this->assertEquals(0, Post::count());
    }
}
