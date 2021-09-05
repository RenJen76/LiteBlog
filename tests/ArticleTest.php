<?php

use App\Article;
use App\User;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ArticleTest extends TestCase
{

    use WithoutMiddleware;
    
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    /*
    public function testShowArticle()
    {
        $articles = Article::all();
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $articles);
        // $this->assertEquals(11, count($articles));
    }
    
    public function testCreateArticle()
    {
        $mockUser = User::find(1);
        $this->actingAs($mockUser, 'web')
             ->call('POST', '/user/create-articles', [
                'contentTitle'  => 'Test8899',
                'content'       => '8899'
             ]);
        $this->seeInDatabase('article_list', [
            'user_id'           => 1,
            'article_title'     => 'Test8899',
            'article_content'   => '8899'
        ]);
    }
    */

    public function testArticleUpdate()
    {
        $mockUser = User::find(1);
        $article  = Article::create([
            'user_id'           => 1,
            'article_title'     => 'BEFORE_TITLE',
            'article_content'   => 'BEFORE_CONTENT'
        ]);

        $response = $this->actingAs($mockUser, 'web')
             ->call('POST', '/user/edit-article/' . $article->article_id, [
                'contentTitle'  => 'AFTER_TITLE',
                'content'       => 'AFTER_CONTENT'
             ]);
           
        $this->seeInDatabase('article_list', [
            'article_id'        => $article->article_id,
            'article_title'     => 'AFTER_TITLE',
            'article_content'   => 'AFTER_CONTENT'
        ]);
        
    }
}
