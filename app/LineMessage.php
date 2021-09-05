<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LineMessage extends Model
{
    protected $table        = 'message_receives';
    protected $primaryKey   = 'receive_id';
    protected $fillable     = [
        'message_id', 'user_uuid', 'message_type', 
        'message_content', 'reply_token', 'send_at',
        'receive_at'
    ];
    public $timestamps      = false;

    public function scopeLastMessage($query, $uuid)
    {
        return $query->where('user_uuid', $uuid)->orderBy('receive_id', 'DESC')->take(1);
    }
}
