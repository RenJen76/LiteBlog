<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Flight extends Model
{

    use SoftDeletes;

    //資料表名稱
    protected $table = 'flights';

    //主鍵名稱
    protected $primaryKey = 'id';

    protected $fillable = [
        'account'
    ];

    /**
     * 需要被轉換成日期的屬性。
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
}
