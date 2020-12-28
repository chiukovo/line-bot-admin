<?php

namespace App\Http\Controllers;

use App\Models\LineMessage;
use Request, Auth, DB, Hash, Storage;

class AdminController extends Controller
{
    public function login()
    {
        return view('admin/login');
    }

    public function doLogin()
    {
        $postData = Request::input();
        
        $account = $postData['account'] ?? '';
        $password = $postData['password'] ?? '';

        if (Auth::attempt([
            'account' => $account,
            'password' => $password
        ])) {
            return response()->json([
                'status' => 'success',
            ]);
        }

        return response()->json([
            'status' => 'error',
            'msg' => '帳號或密碼錯誤'
        ]);
    }

    public function index()
    {
        $data = Request::input();

        $account = $data['account'] ?? '';
        $name = $data['name'] ?? '';

        $filters = [];
        
        if ($name != '') {
            $filters['name'] = $name;
        }

        if ($account != '') {
            $filters['account'] = $account;
        }

        $adminData = DB::table('admin_users');

        if (!empty($filters)) {
            $adminData->where($filters);
        }

        $adminData = $adminData
            ->get()
            ->toArray();

        return view('admin/adminUser/list', [
            'adminData' => $adminData,
            'account' => $account,
            'name' => $name,
        ]);
    }


    public function adminUserEdit()
    {
        $routeName = Request::route()->getName();
        
        $isEdit = false;
        $id = Request::input('id', '');
        $account = '';
        $name = '';

        if ($routeName == 'adminUserEdit') {
            $isEdit = true;
        }

        if ($id != '') {
            $adminUser = DB::table('admin_users')
                ->where('id', $id)
                ->get()
                ->first();
            
            if (is_null($adminUser)) {
                return redirect('/admin/');
            }

            $account = $adminUser->account;
            $name = $adminUser->name;
        }

        return view('admin/adminUser/edit', [
            'isEdit' => $isEdit,
            'name' => $name,
            'account' => $account,
            'id' => $id,
            'word' => $isEdit ? '編輯' : '新增'
        ]);
    }

    public function adminUserDoDelete()
    {
        $id = Request::input('id', '');

        if ($id == 1 || $id == '') {
            return response()->json([
                'status' => 'error',
                'msg' => '此帳號無法刪除或id為空'
            ]);
        }

        DB::table('admin_users')
            ->where('id', $id)
            ->delete();

        return response()->json([
            'status' => 'success',
        ]);
    }

    public function adminUserDoEdit()
    {
        $postData = Request::input();
        $date = date('Y-m-d H:i:s');

        $id = $postData['id'] ?? '';
        $name = $postData['name'] ?? '';
        $account = $postData['account'] ?? '';
        $password = $postData['password'] ?? '';
        $re_password = $postData['re_password'] ?? '';

        if ($password != '' && $re_password != '') {
            if ($password != $re_password) {
                return response()->json([
                    'status' => 'error',
                    'msg' => '重複密碼輸入不正確'
                ]);
            }
        }

        if ($id == '') {
            //create
            if ($name == '' || $account == '' || $password == '' || $re_password == '') {
                return response()->json([
                    'status' => 'error',
                    'msg' => '必填欄位尚未填寫'
                ]);
            }

            //檢查是否帳號已存在
            $checkAccount = DB::table('admin_users')
                ->where('account', $account)
                ->get()
                ->first();

            if (!is_null($checkAccount)) {
                return response()->json([
                    'status' => 'error',
                    'msg' => '此帳號已存在'
                ]);
            }

            DB::table('admin_users')->insert([
                'name' => $name,
                'account' => $account,
                'password' => Hash::make($password),
                'created_at' => $date,
                'updated_at' => $date
            ]);

            return response()->json([
                'status' => 'success',
            ]);
        } else {
            //update
            if ($name == '') {
                return response()->json([
                    'status' => 'error',
                    'msg' => '必填欄位尚未填寫'
                ]);
            }
            
            $updateData = [
                'name' => $name,
                'updated_at' => $date
            ];

            if ($password != '') {
                $updateData['password'] = Hash::make($password);
            }

            DB::table('admin_users')
                ->where('id', $id)
                ->update($updateData);

            return response()->json([
                'status' => 'success',
            ]);
        }
    }

    public function groupList()
    {
        $data = Request::input();

        $name = $data['name'] ?? '';

        $filters = [];

        if ($name != '') {
            $filters['name'] = $name;
        }

        $groupList = DB::table('line_group');

        if (!empty($filters)) {
            $groupList->where($filters);
        }

        $groupList = $groupList
            ->get()
            ->toArray();

        return view('admin/group/list', [
            'groupList' => $groupList,
            'name' => $name,
        ]);
    }

    public function groupUserList()
    {
        $data = Request::input();

        $groupId = $data['group_id'] ?? '';
        $name = $data['name'] ?? '';

        if ($groupId == '') {
            return redirect('/admin/bot/group/list');
        }

        $groupUserList = DB::table('line_group_user')
            ->where('group_id', $groupId)
            ->get()
            ->toArray();

        if (empty($groupUserList)) {
            return redirect('/admin/bot/group/list');
        }

        return view('admin/group/user/list', [
            'groupUserList' => $groupUserList,
            'name' => $name,
        ]);
    }

    public function togglePrintSetting()
    {
        $data = Request::input();

        $setting = (int)$data['setting'] ?? 0;
        $id = (int)$data['id'] ?? '';

        if ($setting === '' || $id === '') {
            return response()->json([
                'status' => 'error',
                'msg' => '參數錯誤'
            ]);
        }

        DB::table('line_group')
            ->where('id', $id)
            ->update([
                'print_open' => $setting
            ]);

        return response()->json([
            'status' => 'success',
        ]);
    }

    public function groupPrint()
    {
        return view('admin/group/print', [
        ]);
    }

    public function groupPrintSuccess()
    {
        $ids = Request::input('ids', '');

        if ($ids == '') {
            return response()->json([
                'status' => 'error',
                'msg' => '參數為空'
            ]);
        }

        try {
            $decodeIds = decrypt($ids);
        } catch (\Throwable $e) {
            report($e);

            return response()->json([
                'status' => 'error',
                'msg' => '解密錯誤'
            ]);
        }

        if (empty($decodeIds)) {
            return response()->json([
                'status' => 'error',
                'msg' => '參數為空陣列'
            ]);
        }

        DB::table('line_user_message')
            ->whereIn('id', $decodeIds)
            ->update([
                'print_type' => 2,
                'updated_at' => date('Y-m-d H:i:s')
            ]);

        return response()->json([
            'status' => 'success',
        ]);
    }
    
    public function getGroupPrint()
    {
        $data = Request::input();
        
        //取出可用群組
        $groupData = DB::table('line_group')
            ->where('print_open', 1)
            ->get(['group_id', 'name'])
            ->toArray();

        $groupIds = [];
        $groupIdsName = [];

        foreach ($groupData as $group) {
            $groupIds[] = $group->group_id;
            $groupIdsName[$group->group_id] = $group->name;
        }

        $message = LineMessage::where('print_type', 1)
            ->join('line_group_user as u', 'line_user_message.user_id', '=', 'u.user_id')
            ->whereIn('line_user_message.group_id', $groupIds)
            ->orderBy('line_user_message.created_at', 'asc')
            ->get([
                'line_user_message.id as id',
                'line_user_message.group_id as group_id',
                'line_user_message.user_id as user_id',
                'line_user_message.type as type',
                'line_user_message.print_type as print_type',
                'line_user_message.msg as msg',
                'line_user_message.picture_url as m_picture_url',
                'line_user_message.created_at as created_at',
                'u.picture_url as u_picture_url',
                'u.name as u_name',
            ])
            ->groupBy('user_id')
            ->toArray();

        $message = array_values($message);

        //目標
        $targets = [];
        $msgs = [];
        $image = [];
        $result = [];
        $ids = [];
        $imageIds = [];
        $msgIds = [];
        $groupName = '';
        $groupUrl = '';
        $groupId = '';
        $userName = '';
        $userUrl = '';
        $userInfo = [];

        $imgCreated = '';
        $msgCreated = '';

        if (!empty($message)) {
            $targets = $message[0];
            //中止點
            $stopString = '#印出';

            //先找圖片
            foreach($targets as $target) {
                $groupName = $groupIdsName[$target['group_id']];
                $groupId = $target['group_id'];
                $groupUrl = $target['m_picture_url'];
                $userName = $target['u_name'];
                $userUrl = $target['u_picture_url'];

                if ($target['type'] == 1) {
                    $image[] = [
                        'id' => $target['id'],
                        'type' => $target['type'],
                        'picture_url' => $target['m_picture_url'],
                        'created_at' => $target['created_at'],
                    ];
                    $imageIds[] = $target['id'];
                    $imgCreated = $target['created_at'];
                    break;
                }
            }

            //找訊息
            foreach ($targets as $target) {
                if ($target['type'] == 0) {
                    if ($msgCreated == '') {
                        $msgCreated = $target['created_at'];
                    }

                    $msg = trim($target['msg']);
                    $msgs[] = [
                        'id' => $target['id'],
                        'type' => $target['type'],
                        'msg' => $msg,
                        'created_at' => $target['created_at'],
                    ];
                    $msgIds[] = $target['id'];

                    if ($msg == $stopString) {
                        break;
                    }
                }
            }
        }

        if (!empty($image) && !empty($msgs)) {
            if (strtotime($imgCreated) > strtotime($msgCreated)) {
                $result = $msgs;
                $ids = $msgIds;
            } else {
                $result = $image;
                $ids = $imageIds;
            }
        } else {
            $result = empty($image) ? $msgs : $image;
            $ids = empty($image) ? $msgIds : $imageIds;
        }

        return response()->json([
            'status' => 'success',
            'ids' => encrypt($ids),
            'groupId' => $groupId,
            'groupName' => $groupName,
            'groupUrl' => $groupUrl,
            'userName' => $userName,
            'userUrl' => $userUrl,
            'result' => $result
        ]);
    }

    public function groupUserMessage()
    {
        $data = Request::input();

        $groupId = $data['group_id'] ?? '';
        $userId = $data['user_id'] ?? '';
        $uName = $data['user_name'] ?? '';
        $gName = $data['group_name'] ?? '';
        $startDate = $data['start_date'] ?? date('Y-m-d') . ' 00:00:00';
        $endDate = $data['end_date'] ?? date('Y-m-d') . ' 23:59:59';
        $uPictureUrl = $data['user_pic_url'] ?? '';

        if ($groupId == '' || $userId == '') {
            return redirect('/admin/bot/group/list');
        }

        $groupUserMessage = DB::table('line_user_message')
            ->where('group_id', $groupId)
            ->where('user_id', $userId)
            ->whereBetween(DB::raw('DATE(created_at)'), [$startDate, $endDate])
            ->orderBy('created_at', 'asc')
            ->get()
            ->toArray();

        return view('admin/group/user/message', [
            'groupUserMessage' => $groupUserMessage,
            'groupId' => $groupId,
            'userId' => $userId,
            'uPictureUrl' => $uPictureUrl,
            'uName' => $uName,
            'gName' => $gName,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);
    }

    public function logout()
    {
        Auth::logout();

        return redirect('/admin/login');
    }
}
