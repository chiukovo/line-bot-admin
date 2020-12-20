@extends('admin.layouts.app')

@section('content')

<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">LINE機器人群組列表</h4>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="text-right m-t-10 m-b-10">
                <a href="#" class="btn btn-info" onclick="location.reload()">重新刷新</a>
                <a id="updated" href="#" class="btn btn-danger" onclick="location.reload()">群組資料手動更新</a>
            </div>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">LINE機器人群組列表</h5>
                    <div class="table-responsive">
                        <table id="zero_config" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>名稱</th>
                                    <th>群組ID</th>
                                    <th>創建日期</th>
                                    <th>功能</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($groupList as $list)
                                <tr>
                                    <td style="text-align: center;">
                                        <img src="{{ $list->picture_url }}" alt="" style="width: 100px">
                                    </td>
                                    <td>{{ $list->name }}</td>
                                    <td>{{ $list->group_id }}</td>
                                    <td>{{ $list->created_at }}</td>
                                    <td>
                                        <a class="btn btn-success btn-sm" href="/admin/bot/group/user/list?group_id={{ $list->group_id }}&name={{ $list->name }}">
                                            內容
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
    $('#updated').click(function () {
        $.ajax({
            url: '/updateGroupUserInfo',
            success: function(res) {
                alert('更新成功')
            }
        });
    })
</script>
@endsection