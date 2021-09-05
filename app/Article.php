<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{ 
    protected $table        = 'article_list';
    protected $primaryKey   = 'article_id';
    protected $fillable     = ['user_id', 'article_title', 'article_content'];

    public function commits()
    {
        return $this->HasMany('App\Commit', 'article_id');
    }

    public function commitsUser()
    {
        return $this->HasManyThrough('App\User', 'App\Commit', 'article_id', 'id');
    }

    public function Author()
    {
        return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function ScopeActive($query)
    {
        return $query->where('article_status', 0);
    }
}
