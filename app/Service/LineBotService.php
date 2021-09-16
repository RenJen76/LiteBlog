<?php
    namespace App\Service;
   
    use Log;
    use Crypt;
    use App\User;
    use App\LineMessage;
    use LINE\LINEBot;
    use Carbon\Carbon;
    use Exception;
    use LINE\LINEBot\HTTPClient\CurlHTTPClient;
    use LINE\LINEBot\MessageBuilder\TextMessageBuilder;

    class LineBotService
    {

        public $bot;
        public $httpClient;

        public function __construct()
        {
            $httpClient       = new CurlHTTPClient(config('app.LINEAccessToken'));
            $this->bot        = new LINEBot($httpClient, ['channelSecret' => config('app.LINEChannelSecret')]);
            $this->httpClient = $httpClient;
        }

        public function webhook($request)
        {
            Log::debug($request);

            if ($this->isTestHook($request)) {
                return $this->responseResult();
            }
            
            $lineMessage = $this->storeMessage($request);
            return $this->mappingResult($lineMessage);
        }

        public function isTestHook($request)
        {       
            $event = $request->input('events');
            if (!is_null($event)) {
                return count($event)===0 ? true : false;
            }
            return true;
        }

        public function storeMessage($request)
        {
            $timestamp  = $request->input('events.0.timestamp') / 1000;
            $lineMessage= LineMessage::create([
                'message_id'      => $request->input('events.0.message.id'),
                'user_uuid'       => $request->input('events.0.source.userId'),
                'message_type'    => $request->input('events.0.type'),
                'message_content' => $request->input('events.0.message.text'),
                'reply_token'     => $request->input('events.0.replyToken'),
                'send_at'         => Carbon::createFromTimestamp($timestamp),
                'receive_at'      => Carbon::now()->toDateTimeString()
            ]);
            return $lineMessage;
        }

        public function mappingResult(LineMessage $lineMessage)
        {
            $userUUID       = $lineMessage->user_uuid;
            $messageContent = $lineMessage->message_content;
            $replyToken     = $lineMessage->replyToken;

            if ($this->isBindMessage($userUUID)) {
                return $this->bindProcess($lineMessage);
            }

            return $this->normalResult($lineMessage);
        }

        public function normalResult(LineMessage $lineMessage)
        {
            $replyMessage   = '';
            $messageContent = $lineMessage->message_content;
            $replyToken     = $lineMessage->reply_token;

            switch ($messageContent) {
                case '綁定':
                    $replyMessage = '請輸入綁定代碼';
                    break;
                default:
                    $replyMessage = $messageContent;
                    break;
            }

            return $this->replyUser($replyToken, $replyMessage);
        }
        
        public function bindProcess(LineMessage $lineMessage)
        {
            $bindCode   = $lineMessage->message_content;
            $replyToken = $lineMessage->reply_token;

            try {

                $userID = Crypt::decrypt($bindCode);

            } catch (Exception $e) {

                return $this->replyUser($replyToken, '查無此綁定代碼，請重新綁定');

            }

            $user = User::find($userID);

            if ($user) {

                $lineUUID = $user->Line_UUID;             

                if ($lineUUID) {
                    return $this->replyUser($replyToken, '此編號已綁定，請重新確認');
                }
                
                $user->Line_UUID = $lineMessage->user_uuid;
                $user->save();

                return $this->replyUser($replyToken ,'綁定完成');
            }

            return $this->responseResult();
        }

        public function responseResult($responseArray = null)
        {
            $responseArray = $responseArray ?? array('result' => 'received');
            $result        = response()->json($responseArray);
            Log::debug($result);
            return $result;
        }

        public function isBindMessage($userUUID = null)
        {
            $lastMessage = LineMessage::lastMessage($userUUID)->first();
            
            if (!$lastMessage) {
                return false;
            }

            return ($lastMessage->message_content === '綁定') ? true : false;
        }

        public function replyUser($replyToken, $replyMessage)
        {
            if (!$replyToken) {
                return $this->responseResult([
                    'result' => '\'reply_token\' not exist.'
                ]);
            }
            
            $textMessageBuilder = new TextMessageBuilder($replyMessage);
            $response           = $this->bot->replyMessage($replyToken, $textMessageBuilder);

            if ($response->isSucceeded()) {
                return $this->responseResult([
                    'result' => 'reply successed.'
                ]);
            }

            return $this->responseResult([
                'result' => 'reply failed.'
            ]);
      
        }

        public function pushMessage()
        {
            // $textMessageBuilder = new TextMessageBuilder($replyMessage);
            // $response = $this->bot->pushMessage('', $textMessageBuilder);
        }
    }
?>