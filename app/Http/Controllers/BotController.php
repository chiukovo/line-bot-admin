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
        $date = date('Y-m-d');
        $dateTime = date('Y-m-d H:i:s');
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
                
                if ($event instanceof BaseEvent) {
                    if (!$event->isGroupEvent()) {
                        continue;
                    }
                }

                //檢查群組是否有新增過
                $groupId = $event->getGroupId();
                $userId = $event->getUserId();

                $group = DB::table('line_group')
                    ->where('group_id', $groupId)
                    ->get('id')
                    ->first();

                if (is_null($group)) {
                    //create group info
                    $this->getGroupProfile($groupId);
                }

                $groupUser = DB::table('line_group_user')
                    ->where('group_id', $groupId)
                    ->where('user_id', $userId)
                    ->get('id')
                    ->first();

                if (is_null($groupUser)) {
                    //create group info
                    $this->getUserProfile($groupId, $userId);
                }

                //訊息的話
                if ($event instanceof MessageEvent) {
                    $msgId = $event->getMessageId();
                    $msgType = $event->getMessageType();
                    $type = 0;
                    $text = '';
                    $pictureUrl = '';

                    //文字
                    if ($msgType == 'text') {
                        $text = $event->getText();
                    }

                    //圖片
                    if ($msgType == 'image') {
                        $type = 1;
                        $response = $this->lineBot->getMessageContent($msgId);

                        if ($response->isSucceeded()) {

                        }
                    }

                    //insert
                    DB::table('line_user_message')->insert([
                        'date' => $date,
                        'group_id' => $groupId,
                        'user_id' => $userId,
                        'type' => $type,
                        'msg' => $text,
                        'picture_url' => $pictureUrl,
                        'created_at' => $dateTime
                    ]);
                }
            }
        } catch (Exception $e) {
            Log::error($e);
            return;
        }
        return;
    }

    public function updateGroupUserInfo()
    {
        $groups = DB::table('line_group')
            ->get('group_id')
            ->toArray();

        foreach ($groups as $group) {
            $this->getGroupProfile($group->group_id, true);
        }

        $groupUsers = DB::table('line_group_user')
            ->get(['group_id', 'user_id'])
            ->toArray();

        foreach ($groupUsers as $users) {
            $this->getUserProfile($users->group_id, $users->user_id, true);
        }

        echo 'done';
    }

    public function getUserProfile($groupId, $userId, $updated = false)
    {
        $response = $this->lineBot->getGroupMemberProfile($groupId, $userId);

        if ($response->isSucceeded()) {
            $profile = $response->getJSONDecodedBody();
            $displayName = $profile['displayName'];
            $userPictureUrl = $profile['pictureUrl'];

            if ($updated) {
                //insert
                DB::table('line_group_user')
                    ->where('group_id', $groupId)
                    ->where('user_id', $userId)
                    ->update([
                        'name' => $displayName,
                        'picture_url' => $userPictureUrl,
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
            } else {
                //insert
                DB::table('line_group_user')->insert([
                    'group_id' => $groupId,
                    'user_id' => $userId,
                    'name' => $displayName,
                    'picture_url' => $userPictureUrl,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            }


        } else {
            Log::debug($response->getRawBody());
        }
    }

    public function getGroupProfile($groupId, $updated = false)
    {
        $groupSummary = $this->lineBot->getGroupSummary($groupId);

        if ($groupSummary->isSucceeded()) {
            $profile = $groupSummary->getJSONDecodedBody();
            $groupName = $profile['groupName'];
            $groupPictureUrl = $profile['pictureUrl'];

            if ($updated) {
                //insert
                DB::table('line_group')
                    ->where('group_id', $groupId)
                    ->update([
                        'name' => $groupName,
                        'picture_url' => $groupPictureUrl,
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);

            } else {
                //insert
                DB::table('line_group')->insert([
                    'group_id' => $groupId,
                    'name' => $groupName,
                    'picture_url' => $groupPictureUrl,
                    'created_at' => date('Y-m-d H:i:s')
                ]);
            }

        } else {
            Log::debug($groupSummary->getRawBody());
        }
    }
}
