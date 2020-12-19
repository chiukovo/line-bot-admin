<?php

namespace App\Http\Controllers;

use LINE\LINEBot;
use LINE\LINEBot\Constant\HTTPHeader;
use LINE\LINEBot\Event\MessageEvent;
use LINE\LINEBot\Event\JoinEvent;
use LINE\LINEBot\SignatureValidator;
use LINE\LINEBot\Event\LeaveEvent;
use LINE\LINEBot\Event\MemberJoinEvent;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use Illuminate\Http\Request;
use Log, Storage, DB;

class BotController extends Controller
{
    public function __construct()
    {
        $this->lineAccessToken = env('LINE_BOT_CHANNEL_ACCESS_TOKEN');
        $this->lineChannelSecret = env('LINE_BOT_CHANNEL_SECRET');

        $httpClient = new CurlHTTPClient($this->lineAccessToken);
        $this->lineBot = new LINEBot($httpClient, ['channelSecret' => $this->lineChannelSecret]);
    }

    public function reply(Request $request)
    {
        $signature = $request->headers->get(HTTPHeader::LINE_SIGNATURE);

        if ($signature == '') {
            return;
        }

        if (!SignatureValidator::validateSignature($request->getContent(), $this->lineChannelSecret, $signature)) {
            return;
        }

        try {
            $events = $this->lineBot->parseEventRequest($request->getContent(), $signature);

            foreach ($events as $event) {
                $this->userId = $event->getUserId();
                $replyToken = $event->getReplyToken();
                Log::info(json_encode($event));

                //訊息的話
                if ($event instanceof MessageEvent) {
                    $msgId = $event->getMessageId();
                    $msgType = $event->getMessageType();

                    //文字
                    if ($msgType == 'text') {

                    }
                }

                if ($event instanceof JoinEvent) {

                }

                if ($event instanceof LeaveEvent) {
                    
                }

                if ($event instanceof MemberJoinEvent) {

                }
            }
        } catch (Exception $e) {
            Log::error($e);
            return;
        }
        return;
    }
}
