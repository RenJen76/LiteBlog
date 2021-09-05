<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    //資料表名稱
    protected $table = 'accounts';

    //主鍵名稱
    protected $promaryKey = 'sernum';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    // public $timestamps = false;

    //可變動欄位
    protected $fillable = [
        'name',
        'account',
        'password',
        'enabled'
    ];

    // protected $guarded  = [];
}
