@extends('admin.layouts.app')

@section('content')

<style>
    .card {
        margin-bottom: 130px;
    }

    .card:last-child {
        margin-bottom: 20px;
    }

    .seconds {
        font-size: 32px;
        color: red;
    }

    .autoPrint {
        margin: 0 20px;
    }

    .word-pre {
        width: 640px;
        position: relative;
        left: 5%;
        font-size: 28px;
        border: none;
        white-space: pre-wrap;
        /* css-3 */
        white-space: -moz-pre-wrap;
        /* Mozilla, since 1999 */
        white-space: -pre-wrap;
        /* Opera 4-6 */
        white-space: -o-pre-wrap;
        /* Opera 7 */
        word-wrap: break-word;
        /* Internet Explorer 5.5+ */
    }
</style>

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
                <span class="autoPrint" v-if="autoPrint">自動列印倒數: <b id="seconds" class="seconds">@{{ ids == '' ? noData : autoSeconds }}</b></span>
                <a href="#" class="btn btn-info" @click="doAutoPrint(1)" v-if="!autoPrint">自動列印開啟</a>
                <a href="#" class="btn btn-danger" @click="doAutoPrint(0)" v-else>自動列印關閉</a>
            </div>
            <div id="printContent">
                <div class="card" v-for="list in result">
                    <div class="card-body">
                        <h2 class="card-title">群組名稱: <b>@{{ list.group_name }}</b></h2>
                        <div class="table-responsive">
                            <table id="zero_config" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="20%">名稱</th>
                                        <th width="60%">內容</th>
                                        <th width="20%">時間</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <img :src="list.u_picture_url" style="width: 50px">
                                            @{{ list.u_name }}
                                        </td>
                                        <td>
                                            <div style="width: 700px;height: 1244px;display: flex;align-items: center;">
                                                <pre class="word-pre" v-if="list.type == 0" v-html="list.msg">
                                                    @{{ list.msg }}
                                                </pre>
                                                <span v-else>
                                                    <img :src="list.m_picture_url" style="width: 700px;height: 1244px;">
                                                </span>
                                            </div>
                                        </td>
                                        <td>@{{ list.created_at }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <pre>
    教學：
    1.只要有圖片皆會印出

    2.印出文字 (只要文字裡有印出兩個字 皆會印出)
    範例: 威力彩 xx000 123 印出 
</pre>
</div>

<script>
    var app = new Vue({
        el: '#app',
        data: {
            ids: '',
            result: [],
            autoPrint: false,
            settingSeconds: 5,
            autoSeconds: 0,
            dataSuccess: false,
            noData: '無資料',
        },
        mounted: function() {
            let $this = this

            $this.init()
            $this.autoSeconds = $this.settingSeconds

            //倒數
            window.setInterval(function() {
                if ($this.autoPrint) {
                    $this.init()
                }

                if ($this.autoPrint && $this.ids != '') {
                    $this.autoSeconds--

                    if ($this.autoSeconds == 0) {
                        $this.doPrint()
                        $this.autoSeconds = $this.settingSeconds
                    }
                }
            }, 1000)
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
                            $this.result = res.result
                        }
                    }
                });
            },
            doAutoPrint: function(val) {
                this.autoPrint = val
                this.autoSeconds = this.settingSeconds
                this.init()
            },
            doPrint: function() {
                let main = document.getElementById('main-wrapper')
                let targetContent = document.getElementById('print-content-copy')
                let headhtml = "<html><head><title></title></head><body>"
                let foothtml = "</body>"
                let newhtml = $("#printContent").html()
                let oldhtml = document.body.innerHTML

                targetContent.style.display = "block"
                main.style.display = "none"
                targetContent.innerHTML = headhtml + newhtml + foothtml
                window.print()
                main.style.display = "block"
                targetContent.style.display = "none"
                this.success()
                this.init()
            },
            success: function() {
                let $this = this

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
                })
            }
        }
    })
</script>
@endsection