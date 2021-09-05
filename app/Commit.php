<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Commit extends Model
{
    protected $table        = 'article_commits';
    protected $primaryKey   = 'commit_id';
    protected $fillable     = ['article_id', 'user_id', 'commit_content', 'created_at'];
    public    $timestamps   = false;

    public function getArticle()
    {
        return $this->belongsTo('App\Article', 'article_id', 'article_id');
    }

    public function commit_user()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

}
