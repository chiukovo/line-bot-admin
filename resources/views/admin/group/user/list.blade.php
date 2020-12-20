@extends('admin.layouts.app')

@section('content')

<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">{{ $name }}群組成員</h4>
            <div class="ml-auto text-right">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="/admin/bot/group/list">LINE BOT群組列表</a></li>
                      <li class="breadcrumb-item active" aria-current="page">{{ $name }}群組成員</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="text-right m-t-10 m-b-10">
                <a href="#" class="btn btn-info" onclick="location.reload()">重新刷新</a>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">{{ $name }}群組成員</h5>
                    <div class="table-responsive">
                        <table id="zero_config" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>名稱</th>
                                    <th>群組ID</th>
                                    <th>成員ID</th>
                                    <th>創建日期</th>
                                    <th>功能</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($groupUserList as $list)
                                <tr>
                                    <td style="text-align: center;">
                                        <img src="{{ $list->picture_url }}" alt="" style="width: 100px">
                                    </td>
                                    <td>{{ $list->name }}</td>
                                    <td>{{ $list->group_id }}</td>
                                    <td>{{ $list->user_id }}</td>
                                    <td>{{ $list->created_at }}</td>
                                    <td>
                                        <a class="btn btn-success btn-sm" href="/admin/bot/group/user/message?group_id={{ $list->group_id }}&user_id={{ $list->user_id }}&group_name={{ $name }}&user_name={{ $list->name }}&user_pic_url={{ $list->picture_url }}">
                                            對話內容
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function del(id, account) {
        var yes = confirm('確定要刪除帳號 ' + account + ' 嗎？');

        if (yes) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/admin/user/delete',
                data: {
                    id: id
                },
                type: 'DELETE',
                success: function(res) {
                    if (res.status == 'success') {
                        location.reload();
                    } else {
                        toastr.warning(res.msg, '訊息');
                    }
                }
            });
        } else {
            return
        }
    }
</script>
@endsection