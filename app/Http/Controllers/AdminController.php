<?php

namespace App\Http\Controllers;

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
