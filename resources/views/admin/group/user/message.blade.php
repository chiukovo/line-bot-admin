@extends('admin.layouts.app')

@section('content')

<link href="/assets/libs/bootstrap-datetimepicker/dist/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<script src="/assets/libs/bootstrap-datetimepicker/dist/js/moment.js"></script>
<script src="/assets/libs/bootstrap-datetimepicker/dist/js/bootstrap-datetimepicker.min.js"></script>
<script src="/assets/libs/bootstrap-datetimepicker/dist/js/zh-tw.js"></script>

<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">{{ $gName }}群組 {{ $uName }}對話紀錄</h4>
            <div class="ml-auto text-right">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="/admin/bot/group/list">LINE BOT群組列表</a></li>
                      <li class="breadcrumb-item"><a href="/admin/bot/group/user/list?group_id={{ $groupId }}">{{ $gName }}群組成員</a></li>
                      <li class="breadcrumb-item active" aria-current="page">{{ $gName }}群組 {{ $uName }}對話紀錄</li>
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
                    <h5 class="card-title">{{ $gName }}群組 {{ $uName }}對話紀錄</h5>
                    <form action="">
                        <div class="form form-row align-items-center m-b-10">
                            <div class="col-auto text-xs">日期</div>
                            <div class="col-auto">
                                <label class="text-xs sr-only">日期</label>
                                <input  class="date" type="text" name="start_date" value="{{ $startDate }}"> ~ <input class="date" type="text" name="end_date" value="{{ $endDate }}">
                            </div>
                            <div class="col-auto">
                                <button class="btn btn-info">搜尋</button>
                            </div>
                        </div>
                        <input type="hidden" name="group_id" value="{{ $groupId }}">
                        <input type="hidden" name="user_id" value="{{ $userId }}">
                        <input type="hidden" name="user_pic_url" value="{{ $uPictureUrl }}">
                        <input type="hidden" name="user_name" value="{{ $uName }}">
                        <input type="hidden" name="group_name" value="{{ $gName }}">
                    </form>
                    <div class="table-responsive">
                        <table id="zero_config" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>名稱</th>
                                    <th>內容</th>
                                    <th>狀態</th>
                                    <th>日期</th>
                                    <th>功能</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($groupUserMessage as $list)
                                <tr>
                                    <td style="width: 20%">
                                        <img src="{{ $uPictureUrl }}" alt="" style="width: 100px">
                                        {{ $uName }}
                                    </td>
                                    <td style="width: 30%">
                                        @if($list->type == 0)
                                        {{ $list->msg }}
                                        @else
                                        <img src="{{ $list->picture_url }}" alt="">
                                        @endif
                                    </td>
                                    <td style="width: 10%">
                                        @if($list->print_type == 0)
                                        <span class="badge badge-secondary">不需影印</span>
                                        @elseif($list->print_type == 1)
                                        <span class="badge badge-info">等待列印</span>
                                        @elseif($list->print_type == 2)
                                        <span class="badge badge-success">列印完畢</span>
                                        @endif
                                    
                                    </td>
                                    <td style="width: 10%">{{ $list->created_at }}</td>
                                    <td style="width: 10%">
                                        @if(($list->msg == '#印出' || $list->type == 1) && $list->print_type == 2)
                                        <a href="#" class="rePrint btn btn-danger btn-sm" data-id="{{ $list->id }}">
                                            重新列印
                                        </a>
                                        @endif
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
    $(".date").datetimepicker({
        locale: 'zh-tw',//使用繁體中文界面
        format: 'YYYY-MM-DD HH:mm:ss',//日期時間格式
    });

    $('.rePrint').click(function(e) {
        e.preventDefault();
        const id = $(this).attr('data-id')

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '/admin/bot/group/rePrint',
            data: {
                id, id
            },
            type: 'POST',
            success: function(res) {
                if (res.status == 'success') {
                   alert('重新列印設定成功')
                   location.reload()
                } else {
                    alert(res.msg)
                }
            }
        });
    });
</script>
@endsection