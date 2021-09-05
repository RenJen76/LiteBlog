<?php

namespace App\Listeners;

use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use App\Events\CommentReminderEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CommentReminder
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  CommentReminderEvent  $event
     * @return void
     */
    public function handle(CommentReminderEvent $event)
    {
        $article    = $event->article;
        $author     = $article->Author;
        
        if($author && $author->Line_UUID){
            $articleURL = url('/articles/'.$article->article_id);
            $LineUUID   = $author->Line_UUID;
            $httpClient = new CurlHTTPClient(env('LINE_CHANNEL_ACCESS_TOKEN'));
            $bot        = new LINEBot($httpClient, ['channelSecret' => env('LINE_CHANNEL_SECRET')]);
            $textMessageBuilder = new TextMessageBuilder('Hey! 有人回覆您的此篇文章囉!' . $articleURL);
            $bot->pushMessage($LineUUID, $textMessageBuilder);
        }
    }
}
