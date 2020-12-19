<?php

namespace App\Http\Controllers;

use LINE\LINEBot;
use LINE\LINEBot\Constant\HTTPHeader;
use LINE\LINEBot\Event\MessageEvent;
use LINE\LINEBot\Event\JoinEvent;
use LINE\LINEBot\Event\BaseEvent;
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
                $replyToken = $event->getReplyToken();

                $userInfo = $this->getUserProfile($event);
                Log::info(json_encode($userInfo));

                //訊息的話
                if ($event instanceof MessageEvent) {
                    $msgId = $event->getMessageId();
                    $msgType = $event->getMessageType();

                    //文字
                    if ($msgType == 'text') {
                        $text = $event->getText();
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

    public function getUserProfile($event)
    {
        $return = [
            'userId' => '',
            'groupId' => '',
            'roomId' => '',
            'displayName' => '',
        ];

        //base
        if ($event instanceof BaseEvent) {
            $return['userId'] = $event->getUserId();

            //user
            if ($event->isUserEvent()) {
                if (!is_null($return['userId'])) {
                    $response = $this->lineBot->getProfile($return['userId']);

                    if ($response->isSucceeded()) {
                        $profile = $response->getJSONDecodedBody();
                        $return['displayName'] = $profile['displayName'];  
                    } else {
                        Log::debug($response->getRawBody());
                    }
                }
            }

            //group
            if ($event->isGroupEvent()) {
                $this->groupId = $event->getGroupId();

                if (!is_null($return['userId']) && !is_null($this->groupId)) {
                    $response = $this->lineBot->getGroupMemberProfile($this->groupId, $return['userId']);

                    if ($response->isSucceeded()) {
                        $profile = $response->getJSONDecodedBody();
                        $this->displayName = $profile['displayName'];  
                    } else {
                        Log::debug($response->getRawBody());
                    }
                }
            }

            //room
            if ($event->isRoomEvent()) {
                $this->roomId = $event->getRoomId();

                if (!is_null($return['userId']) && !is_null($this->roomId)) {
                    $response = $this->lineBot->getRoomMemberProfile($this->roomId, $return['userId']);

                    if ($response->isSucceeded()) {
                        $profile = $response->getJSONDecodedBody();
                        $this->displayName = $profile['displayName'];  
                    } else {
                        Log::debug($response->getRawBody());
                    }
                }
            }
        }

        return $return;
    }
}
