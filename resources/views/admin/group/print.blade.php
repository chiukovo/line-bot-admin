@extends('admin.layouts.app')

@section('content')

<div class="page-breadcrumb">
    <div class="row">
        <div class="col-12 d-flex no-block align-items-center">
            <h4 class="page-title">群組訊息列印</h4>
            <div class="ml-auto text-right">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="/admin/bot/group/print">群組訊息列印</a></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</div>
<div id="app" class="container-fluid" v-cloak>
    <div class="row">
        <div class="col-12">
            <div class="text-right m-t-10 m-b-10">
                <a id="print" href="#" class="btn btn-info">影印</a>
                <a @click="success" href="#" class="btn btn-success">完成</a>
            </div>

            <div class="card">
                <div id="printContent" class="card-body">
                    <h2 class="card-title">@{{ groupName }}</h2>
                    <div class="table-responsive">
                        <table id="zero_config" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th width="20%">名稱</th>
                                    <th width="60%">內容</th>
                                    <th width="20%">時間</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="list in result">
                                    <td>
                                        <img :src="userUrl" style="width: 50px">
                                        @{{ userName }}
                                    </td>
                                    <td>
                                        <span v-if="list.type == 0">@{{ list.msg }}</span>
                                        <span v-else>
                                            <img :src="list.picture_url" style="width: 300px">
                                        </span>

                                    </td>
                                    <td>@{{ list.created_at }}</td>
                                </tr>
                                <tr v-if="result.length == 0">
                                    <td colspan="3" style="text-align: center;">
                                        尚無任何需印出資料
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <pre>
    教學：
    1.需印出字串請打#
    範例: #aaa #我要印出

    2.印出指令
    輸入: #印出
</pre>
</div>

<script>
    $(document).ready(function() {
        $(document).on("click", "#print", function() {
            let headhtml = "<html><head><title></title></head><body>";
            let foothtml = "</body>";
            let newhtml = $("#printContent").html();
            let oldhtml = document.body.innerHTML;
            document.body.innerHTML = headhtml + newhtml + foothtml;
            window.print();
            document.body.innerHTML = oldhtml;
        })
    })

    var app = new Vue({
        el: '#app',
        data: {
            ids: '',
            groupId: '',
            groupName: '',
            groupUrl: '',
            userName: '',
            userUrl: '',
            result: [],
        },
        mounted: function() {
            this.init()

            window.setInterval((() => this.init()), 2000)
        },
        methods: {
            init: function() {
                let $this = this

                $.ajax({
                    url: '/admin/bot/group/print/get',
                    data: {},
                    type: 'GET',
                    success: function(res) {
                        if (res.status == 'success') {
                            $this.ids = res.ids
                            $this.groupId = res.groupId
                            $this.groupName = res.groupName
                            $this.groupUrl = res.groupUrl
                            $this.userName = res.userName
                            $this.userUrl = res.userUrl
                            $this.result = res.result
                        }
                    }
                });
            },
            success: function(e) {
                e.preventDefault()
                let $this = this

                if (confirm("確定已影印完成？")) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: '/admin/bot/group/print/success',
                        data: {
                            ids: $this.ids
                        },
                        type: 'POST',
                        success: function(res) {
                            if (res.status == 'success') {
                                $this.init()
                            }
                        }
                    });
                }
            }
        }
    })
</script>
@endsection