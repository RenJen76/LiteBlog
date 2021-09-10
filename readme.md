## About LiteBlog


- 應用Laravel、LineBot實踐出小型的社群平台，綁定LineBot後當文章有人回覆時可即時收到通知。


## Installing

1. Clone repository and run `composer install`

2. run `php artisan key:generate` and `php artisan generate:encryptkey` generate encryption key

3. fill in `LINE_CHANNEL_SECRET` and `LINE_CHANNEL_ACCESS_TOKEN` use to LineBot

4. fill in `MAIL_USERNAME` and `MAIL_PASSWORD` use to send mail

5. run `php artisan queue:table` and `php artisan migrate`