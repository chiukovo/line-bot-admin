<!DOCTYPE html>
<html>

<head>
    <title>{{ env('APP_NAME') }}</title>
    <!-- for-mobile-apps -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" sizes="16x16" href="/img/icon.png">
    <script type="application/x-javascript">
        addEventListener("load", function() {
            setTimeout(hideURLbar, 0);
        }, false);

        function hideURLbar() {
            window.scrollTo(0, 1);
        }
    </script>
    <!-- //for-mobile-apps -->
    <link href="/css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
    <link href="/css/style.css?v=1.0.6" rel="stylesheet" type="text/css" media="all" />
    <!-- gallery -->
    <link rel="stylesheet" href="/css/lightGallery.css" type="text/css" media="all" />
    <!-- //gallery -->
    <!-- font-awesome icons -->
    <link href="/css/font-awesome.css" rel="stylesheet">

    <!-- //font-awesome icons -->
    <link href="//fonts.googleapis.com/css?family=Questrial" rel="stylesheet">
    <link href="//fonts.googleapis.com/css?family=Jura:300,400,500,600" rel="stylesheet">
    <link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'>
    <style>
        /* Absolute Center Spinner */
        .loading {
            position: fixed;
            z-index: 999;
            height: 2em;
            width: 2em;
            overflow: show;
            margin: auto;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
        }

        /* Transparent Overlay */
        .loading:before {
            content: '';
            display: block;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(rgba(20, 20, 20, .8), rgba(0, 0, 0, .8));

            background: -webkit-radial-gradient(rgba(20, 20, 20, .8), rgba(0, 0, 0, .8));
        }

        /* :not(:required) hides these rules from IE9 and below */
        .loading:not(:required) {
            /* hide "loading..." text */
            font: 0/0 a;
            color: transparent;
            text-shadow: none;
            background-color: transparent;
            border: 0;
        }

        .loading:not(:required):after {
            content: '';
            display: block;
            font-size: 10px;
            width: 1em;
            height: 1em;
            margin-top: -0.5em;
            -webkit-animation: spinner 150ms infinite linear;
            -moz-animation: spinner 150ms infinite linear;
            -ms-animation: spinner 150ms infinite linear;
            -o-animation: spinner 150ms infinite linear;
            animation: spinner 150ms infinite linear;
            border-radius: 0.5em;
            -webkit-box-shadow: rgba(255, 255, 255, 0.75) 1.5em 0 0 0, rgba(255, 255, 255, 0.75) 1.1em 1.1em 0 0, rgba(255, 255, 255, 0.75) 0 1.5em 0 0, rgba(255, 255, 255, 0.75) -1.1em 1.1em 0 0, rgba(255, 255, 255, 0.75) -1.5em 0 0 0, rgba(255, 255, 255, 0.75) -1.1em -1.1em 0 0, rgba(255, 255, 255, 0.75) 0 -1.5em 0 0, rgba(255, 255, 255, 0.75) 1.1em -1.1em 0 0;
            box-shadow: rgba(255, 255, 255, 0.75) 1.5em 0 0 0, rgba(255, 255, 255, 0.75) 1.1em 1.1em 0 0, rgba(255, 255, 255, 0.75) 0 1.5em 0 0, rgba(255, 255, 255, 0.75) -1.1em 1.1em 0 0, rgba(255, 255, 255, 0.75) -1.5em 0 0 0, rgba(255, 255, 255, 0.75) -1.1em -1.1em 0 0, rgba(255, 255, 255, 0.75) 0 -1.5em 0 0, rgba(255, 255, 255, 0.75) 1.1em -1.1em 0 0;
        }

        /* Animation */

        @-webkit-keyframes spinner {
            0% {
                -webkit-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -ms-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -ms-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }

        @-moz-keyframes spinner {
            0% {
                -webkit-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -ms-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -ms-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }

        @-o-keyframes spinner {
            0% {
                -webkit-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -ms-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -ms-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }

        @keyframes spinner {
            0% {
                -webkit-transform: rotate(0deg);
                -moz-transform: rotate(0deg);
                -ms-transform: rotate(0deg);
                -o-transform: rotate(0deg);
                transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
                -moz-transform: rotate(360deg);
                -ms-transform: rotate(360deg);
                -o-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body>
    <div id="loading" class="loading">
        Loading
    </div>
    @if($isLogin)
    <div class="header user-login">
        @else
        <div class="header">
            @endif
            @if($isLogin)
            <div class="mob user-fixed-top">
                <div class="user-item user-img">
                    <a href="{{ env('LINE_LINK') }}" target="_blank">
                        <img src="/img/service.png">
                    </a>
                </div>
                <div class="user-item user-infor">您好! <span>{{ $user->account }}</span></div>
                <div class="user-item user-out"><a href="logout">登出</a></div>
            </div>
            <div class="mob user-fixed-bottom">
                <div class="user-item"><a href="#" data-toggle="modal" data-target="#downloadGame" data-keyboard="false" data-backdrop="static"><i class="fa fa-download"></i><span>遊戲下載</span></a></div>
                <div class="user-item"><a href="{{ $du }}" target="_blank"><i class="fa fa-question-circle"></i><span>下載教學</span></a></div>
                <div class="user-item"><a href="#" data-toggle="modal" data-target="#activity" data-keyboard="false" data-backdrop="static"><i class="fa fa-bell"></i><span>最新活動</span></a></div>
                <div class="user-item"><a href="{{ env('LINE_LINK') }}" target="_blank"><i class="fa fa-usd"></i><span>購買金幣</span></a></div>
                <div class="user-item"><a href="#" data-toggle="modal" data-target="#memberInfo" data-keyboard="false" data-backdrop="static"><i class="fa fa-user"></i><span>會員資訊</span></a></div>
            </div>
            @endif
            <div class="row">
                <div class="col-xs-12 col-sm-7">
                    <marquee direction="left" style="color: #f9f12f; line-height: 45px">
                        {{ $marquee }}
                    </marquee>
                </div>
                <div class="col-xs-12 col-sm-5">
                    <div class="w3layouts_header_right">
                        @if(!$isLogin)
                        <button class="btn btn-default" data-toggle="modal" data-target="#loginModal" data-keyboard="false" data-backdrop="static">登入</button>
                        <button class="btn btn-primary" data-toggle="modal" data-target="#regModal" data-keyboard="false" data-backdrop="static">註冊</button>
                        @else
                        <div id="pc-use">
                            <span class="hello">您好! {{ $user->account }}</span>
                            <!-- Single button -->
                            <div class="btn-group">
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    會員功能 <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a href="#" data-toggle="modal" data-target="#memberInfo" data-keyboard="false" data-backdrop="static">會員資訊</a></li>
                                    <li><a href="#" data-toggle="modal" data-target="#downloadGame" data-keyboard="false" data-backdrop="static">遊戲下載</a></li>
                                    <li><a href="{{ $du }}" target="_blank">下載教學</a></li>
                                    <li><a href="#" data-toggle="modal" data-target="#activity" data-keyboard="false" data-backdrop="static">最新活動</a></li>
                                    <li><a href="{{ env('LINE_LINK') }}" target="_blank">購買金幣</a></li>
                                </ul>
                            </div>
                            <button class="btn btn-default" onclick="location.href='logout'">登出</button>
                            <a href="{{ env('LINE_LINK') }}" target="_blank">
                                <img src="/img/service.png" alt="" style="width: 50px">
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="clearfix"> </div>
        </div>
        <!-- header -->
        <div class="w3_navigation">
            <div class="container">
                <nav class="navbar navbar-default">
                    <div class="navbar-header navbar-left">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <div class="w3_navigation_pos">
                            <h1><a href="/" title="{{ env('APP_NAME') }}"><img src="/img/logo.png" alt=""></a></h1>
                        </div>
                    </div>
                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse navbar-right" id="bs-example-navbar-collapse-1">
                        <nav class="cl-effect-5" id="cl-effect-5">
                            <ul class="nav navbar-nav">
                                <li class="active"><a href="/"><span data-hover="Home">首頁</span></a></li>

                                <li><a href="#about" class="scroll"><span data-hover="About">關於我們</span></a></li>
                                <li><a href="#services" class="scroll"><span data-hover="Services">遊戲體驗</span></a></li>
                                <li><a href="#work" class="scroll"><span data-hover="Gallery">遊戲畫面</span></a></li>
                                <li><a href="#projects" class="scroll"><span data-hover="Games">最新遊戲</span></a></li>
                                <li><a href="#mail" class="scroll"><span data-hover="Contact">聯絡我們</span></a></li>
                                <li><a href="#mail" class="scroll"><span data-hover="Cooperation">合作提案</span></a></li>
                            </ul>
                        </nav>
                    </div>
                </nav>
            </div>
        </div>
        <!-- //header -->
        <!-- banner -->
        <div class="banner">
            <!--Slider-->
            <div class="slider">
                <div class="callbacks_container">
                    <ul class="rslides" id="slider3">
                        <li>
                            <a href="#" class="slider-img" data-toggle="modal" data-target="#regModal" data-keyboard="false" data-backdrop="static">
                                <img src="/img/banner1.jpg" class="img-responsive" alt="Gaming Wonderland">
                            </a>
                            <!-- <div class="slider-info">

							<h4>{{ env('APP_NAME') }} - 唯我獨尊</h4>
							<p>火熱公測中 </p>
							<a href="#" class="hvr-shutter-in-horizontal scroll">立即註冊</a>
						</div> -->
                        </li>
                        <li>
                            <a href="#" class="slider-img" data-toggle="modal" data-target="#regModal" data-keyboard="false" data-backdrop="static">
                                <img src="/img/banner2.jpg" class="img-responsive" alt="Gaming Wonderland">
                            </a>
                            <!-- <div class="slider-info">

							<h4>{{ env('APP_NAME') }} - 約牌好友</h4>
							<p>一起玩 最好玩!</p>
							<a href="#" class="hvr-shutter-in-horizontal scroll">立即註冊</a>
						</div> -->
                        </li>
                    </ul>

                </div>
                <div class="clearfix"></div>
            </div>
            <!--//Slider-->
        </div>
        <!-- //banner -->
        <!-- Modal1 -->
        <div id="regModal" class="modal fade" role="dialog" aria-hidden="true" aria-labelledby="scrolleTitle">
            <div class="modal-dialog" role="document">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">立即註冊</h4>
                    </div>
                    <div class="modal-body">
                        <form id="form" class="form-horizontal">
                            <div class="form-group required">
                                <label for="account" class="col-sm-3 control-label">會員帳號</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="account" name="account" placeholder="請輸入會員帳號(限制4-12字元)">
                                    <div style="margin: 10px 0">
                                        <button id="checkAccount" type="button" class="btn btn-default">檢查帳號是否能使用</button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group required">
                                <label for="password"" class=" col-sm-3 control-label">設定密碼</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control" id="password" name="password" placeholder="請輸入密碼(限制6-18字元)">
                                </div>
                            </div>
                            <div class="form-group required">
                                <label for="re_password"" class=" col-sm-3 control-label">再次輸入密碼</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control" id="re_password" name="re_password" placeholder="請再次輸入密碼(限制6-18字元)">
                                </div>
                            </div>
                            <div class="form-group required">
                                <label for="name"" class=" col-sm-3 control-label">姓名</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="name"" name=" name" placeholder="請輸入姓名（須以銀行卡相同）">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="nickname"" class=" col-sm-3 control-label">暱稱</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="nickname"" name=" nickname" placeholder="請輸入暱稱">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email" class="col-sm-3 control-label">Email</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="email" name="email" placeholder="請輸入email">
                                </div>
                            </div>
                            <div class="form-group required">
                                <label for="code" class="col-sm-3 control-label">推薦碼</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="code" name="code" value="{{ $code }}" readonly>
                                </div>
                            </div>
                            <div class="form-group required">
                                <label for="phone" class="col-sm-3 control-label">手機</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="phone" name="phone" placeholder="請輸入手機號碼">
                                </div>
                            </div>
                            <div class="form-group required">
                                <label for="verification" class="col-sm-3 control-label">驗證碼</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="verification" name="verification" placeholder="輸入驗證碼">
                                    <div style="margin: 10px 0">
                                        <button id="sendPhoneCode" type="button" class="btn btn-default">取得手機驗證碼</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>
                        <button id="reg" type="button" class="btn btn-primary">送出</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- //Modal1 -->

        <div id="loginModal" class="modal fade" role="dialog" aria-hidden="true" aria-labelledby="scrolleTitle">
            <div class="modal-dialog" role="document">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">登入</h4>
                    </div>
                    <div class="modal-body">
                        <form id="loginForm" class="form-horizontal">
                            <div class="form-group required">
                                <label for="account" class="col-sm-3 control-label">會員帳號</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="account" placeholder="請輸入會員帳號">
                                </div>
                            </div>
                            <div class="form-group required">
                                <label for="password"" class=" col-sm-3 control-label">密碼</label>
                                <div class="col-sm-9">
                                    <input type="password" class="form-control" name="password" placeholder="請輸入密碼">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>
                        <button id="login" type="button" class="btn btn-primary">送出</button>
                    </div>
                </div>
            </div>
        </div>

        <div id="downloadGame" class="modal fade" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">遊戲下載</h4>
                    </div>
                    <div class="modal-body">
                        <a href="{{ $au }}" type="button" class="btn btn-primary btn-lg btn-block" target="_blank">Android版本下載</a>
                        <a href="{{ $iu }}" type="button" class="btn btn-secondary btn-lg btn-block" target="_blank">Ios版本下載</a>
                    </div>
                </div>
            </div>
        </div>

        <div id="activity" class="modal fade" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body" style="max-height: calc(100vh - 250px);">
                        @if($fileName != '')
                        <img src="/storage/{{ $fileName }}" alt="">
                        @endif
                        @if($act != '')
                        <div style="margin: 20px 0">
                            <a href="{{ $act }}" type="button" class="btn btn-primary btn-lg btn-block" target="_blank">前往活動頁面</a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        @if($isLogin)
        <div id="memberInfo" class="modal fade" role="dialog" aria-hidden="true" aria-labelledby="scrolleTitle">
            <div class="modal-dialog" role="document">
                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">會員資訊</h4>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">會員帳號</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" value="{{ $user->account }}" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">暱稱</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" value="{{ $user->nickname }}" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Email</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" value="{{ $user->email }}" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">推薦碼</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" value="{{ $user->code }}" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class=" col-sm-3 control-label">姓名</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" value="{{ $user->name }}" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">手機</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" value="{{ $user->phone }}" readonly>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">關閉</button>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- about -->
        <div class="about" id="about">
            <div class="container">
                <div id="game-logo" class="owl-carousel">
                    <div class="item">
                        <img src="/img/game-logo/1.png" alt="">
                    </div>
                    <div class="item">
                        <img src="/img/game-logo/2.png" alt="">
                    </div>
                    <div class="item">
                        <img src="/img/game-logo/3.png" alt="">
                    </div>
                    <div class="item">
                        <img src="/img/game-logo/4.png" alt="">
                    </div>
                    <div class="item">
                        <img src="/img/game-logo/5.png" alt="">
                    </div>
                    <div class="item">
                        <img src="/img/game-logo/6.png" alt="">
                    </div>
                    <div class="item">
                        <img src="/img/game-logo/7.png" alt="">
                    </div>
                    <div class="item">
                        <img src="/img/game-logo/8.png" alt="">
                    </div>
                    <div class="item">
                        <img src="/img/game-logo/9.png" alt="">
                    </div>
                </div>
                <div class="col-md-4 agileits_about_left">
                    <h3 class="w3l_head">關於我們</h3>
                    <p class="w3ls_head_para">who we are</p>
                </div>
                <div class="agileits_banner_bottom_grids">
                    <div class="col-md-6 agileits_banner_bottom_grid_l" style="margin-top: 2em;">
                        <h4>{{ env('APP_NAME') }}</h4>
                        <p>《{{ env('APP_NAME') }}》正宗台灣麻將遊戲</p>
                        <p>一、隨機配桌，降低夥牌代理風險。</p>
                        <p>二、所有遊戲皆有<b class="text-primary">自開房</b>，群組三五好友隨時相約打牌娛樂<br>（仿間自開房均不計算輸贏）。</p>
                        <p>三、所有遊戲<b class="text-primary">免房卡</b>，代理推廣皆實收益。</p>
                        <p>四、使用微信綁定，無法解綁，杜絕惡意跳線，互搶會員。</p>
                        <p>五、目前開放四人麻將，鬥地主，八支刀，二人麻將，
                            <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;近期開放兩人大老二，吹牛，牛牛，百家樂，二人鬥地主，13支。
                        </p>
                        <p>六、活動周期性舉辦，獎品豐富。</p>
                        <p>七、完善的後台，隨時掌握稅收</p>
                        <p>八、代理開發代理，無限代發展</p>
                        <p>九、遊戲畫面細緻，多種效果互動</p>
                        <p>十、完整專業的工程團隊，24H客服</p>
                        <p><i>您，準備好了嗎？</i></p>
                    </div>
                    <div class="col-md-6 agileits_banner_bottom_grid_r">
                        <div class="agileits_banner_btm_grid_r">
                            <img src="/img/ab.jpg" alt=" " class="img-responsive">
                            <div class="agileits_banner_btm_grid_r_pos">
                                <img src="/img/ab1.jpg" alt=" " class="img-responsive">
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"> </div>
                </div>
            </div>
        </div>
        <!-- //about-bottom -->
        <!-- services -->
        <div class="services" id="services">
            <h3 class="w3l_head w3l_head1">最佳遊戲體驗</h3>
            <p class="w3ls_head_para w3ls_head_para1">View Our Services</p>
            <div class="services-agile-w3l">
                <div class="col-md-3 services-gd text-center">
                    <div class="hi-icon-wrap hi-icon-effect-9 hi-icon-effect-9a">
                        <a href="javascript:void(0)" class="hi-icon"><img src="/img/s1.png" alt=" " /></a>
                    </div>
                    <h4>ONLINE</h4>
                    <p>多人在線遊玩</p>
                </div>

                <div class="col-md-3 services-gd text-center">
                    <div class="hi-icon-wrap hi-icon-effect-9 hi-icon-effect-9a">
                        <a href="javascript:void(0)" class="hi-icon"><img src="/img/s2.png" alt=" " /></a>
                    </div>
                    <h4>BETTER</h4>
                    <p>良好遊戲體驗</p>
                </div>
                <div class="col-md-3 services-gd text-center">
                    <div class="hi-icon-wrap hi-icon-effect-9 hi-icon-effect-9a">
                        <a href="javascript:void(0)" class="hi-icon"><img src="/img/s3.png" alt=" " /></a>
                    </div>
                    <h4>TECHNOLOGY</h4>
                    <p>H5最新技術</p>
                </div>
                <div class="col-md-3 services-gd text-center">
                    <div class="hi-icon-wrap hi-icon-effect-9 hi-icon-effect-9a">
                        <a href="javascript:void(0)" class="hi-icon"><img src="/img/s4.png" alt=" " /></a>
                    </div>
                    <h4>FASTER</h4>
                    <p>低延遲快速遊玩</p>
                </div>
                <div class="clearfix"> </div>
            </div>
        </div>
        <!-- //services -->

        <!-- gallery -->
        <div class="team-bottom" id="work">
            <div class="container">
                <h3 class="w3l_head w3l_head1">遊戲畫面</h3>
                <p class="w3ls_head_para w3ls_head_para1">GAME SCREEN</p>
                <div class="w3layouts_gallery_grids">
                    <ul class="w3l_gallery_grid">
                        <li>
                            <div class="w3layouts_gallery_grid1 box">
                                <a href="#" data-toggle="modal" data-target="#regModal" data-keyboard="false" data-backdrop="static">
                                    <img src="/img/g0.jpg" alt=" " class="img-responsive" />
                                    <div class="overbox">
                                        <h4 class="title overtext">立即註冊</h4>
                                    </div>
                                </a>
                            </div>
                        </li>
                        <li>
                            <div class="w3layouts_gallery_grid1 box">
                                <a href="#" data-toggle="modal" data-target="#regModal" data-keyboard="false" data-backdrop="static">
                                    <img src="/img/g1.jpg" alt=" " class="img-responsive" />
                                    <div class="overbox">
                                        <h4 class="title overtext">立即註冊</h4>
                                    </div>
                                </a>
                            </div>
                        </li>
                        <li>
                            <div class="w3layouts_gallery_grid1 box">
                                <a href="#" data-toggle="modal" data-target="#regModal" data-keyboard="false" data-backdrop="static">
                                    <img src="/img/g2.jpg" alt=" " class="img-responsive" />
                                    <div class="overbox">
                                        <h4 class="title overtext">立即註冊</h4>
                                    </div>
                                </a>
                            </div>
                        </li>
                        <li>
                            <div class="w3layouts_gallery_grid1 box">
                                <a href="#" data-toggle="modal" data-target="#regModal" data-keyboard="false" data-backdrop="static">
                                    <img src="/img/g3.jpg" alt=" " class="img-responsive" />
                                    <div class="overbox">
                                        <h4 class="title overtext">立即註冊</h4>
                                    </div>
                                </a>
                            </div>
                        </li>
                        <li>
                            <div class="w3layouts_gallery_grid1 box">
                                <a href="#" data-toggle="modal" data-target="#regModal" data-keyboard="false" data-backdrop="static">
                                    <img src="/img/g4.jpg" alt=" " class="img-responsive" />
                                    <div class="overbox">
                                        <h4 class="title overtext">立即註冊</h4>
                                    </div>
                                </a>
                            </div>
                        </li>
                        <li>
                            <div class="w3layouts_gallery_grid1 box">
                                <a href="#" data-toggle="modal" data-target="#regModal" data-keyboard="false" data-backdrop="static">
                                    <img src="/img/g5.jpg" alt=" " class="img-responsive" />
                                    <div class="overbox">
                                        <h4 class="title overtext">立即註冊</h4>
                                    </div>
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- //gallery -->
        <!-- projects -->
        <div class="projects" id="projects">
            <div class="container">
                <div class="port-head">
                    <h3 class="w3l_head w3l_head1">最新遊戲</h3>
                    <p class="w3ls_head_para w3ls_head_para1">NEW GAMES</p>
                </div>
            </div>
            <div class="projects-grids">
                <div class="sreen-gallery-cursual">

                    <div id="owl-demo" class="owl-carousel owl-theme">
                        <div class="item">
                            <div class="projects-agile-grid-info">
                                <img src="/img/s1.jpg" alt="" />
                                <div class="projects-grid-caption">
                                    <h4>約牌好友</h4>
                                    <p>隨時隨地最好玩</p>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="projects-agile-grid-info">
                                <img src="/img/s2.jpg" alt="" />
                                <div class="projects-grid-caption">
                                    <h4>神手麻將</h4>
                                    <p>真人三缺一</p>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="projects-agile-grid-info">
                                <img src="/img/s3.jpg" alt="" />
                                <div class="projects-grid-caption">
                                    <h4>{{ env('APP_NAME') }}</h4>
                                    <p>註冊立即送!</p>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="projects-agile-grid-info">
                                <img src="/img/s4.jpg" alt="" />
                                <div class="projects-grid-caption">
                                    <h4>斗地王</h4>
                                    <p>免費體驗</p>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="projects-agile-grid-info">
                                <img src="/img/s5.jpg" alt="" />
                                <div class="projects-grid-caption">
                                    <h4>德州撲克</h4>
                                    <p>公測火熱上式</p>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="projects-agile-grid-info">
                                <img src="/img/s6.jpg" alt="" />
                                <div class="projects-grid-caption">
                                    <h4>斗地王</h4>
                                    <p>免費體驗</p>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="projects-agile-grid-info">
                                <img src="/img/s7.jpg" alt="" />
                                <div class="projects-grid-caption">
                                    <h4>爽贏炸金花</h4>
                                    <p>免費體驗</p>
                                </div>
                            </div>
                        </div>
                        <div class="item">
                            <div class="projects-agile-grid-info">
                                <img src="/img/s8.jpg" alt="" />
                                <div class="projects-grid-caption">
                                    <h4>地道內蒙齊牌</h4>
                                    <p>玩法最正宗</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- //projects -->
        <!-- mail -->
        <div class="mail" id="mail">
            <div class="container">
                <div class="port-head">
                    <h3 class="w3l_head w3l_head1">聯絡我們/合作提案</h3>
                    <p class="w3ls_head_para w3ls_head_para1">CONTACT US / Cooperation</p>
                </div>
                <div class="cooperation">
                    <div class="col-md-2 w3_agile_mail_grid">
                        <img src="/img/logo.png" alt="" style="width: 150px">
                    </div>
                    <div class="col-md-6 w3_agile_mail_grid">
                        天下麻將合作提案說明，<br>
                        如果你有好的方法，好的提案，好的市場，<br>
                        歡迎系統遊戲合作開發，平台合作。
                    </div>
                </div>
            </div>
        </div>
        <!-- footer -->
        <div class="w3l_footer">
            <div class="w3l_footer_pos">
                @if($isLogin)
                <div style="margin-bottom: 10px;">
                    <p><img src="/img/qrcode.jpg" style="width: 200px"></p>
                    <p>LINE ID: <a href="{{ env('LINE_LINK') }}" target="_blank">@847ihzpc</a></p>
                </div>
                @endif

                <p>© 2020 {{ env('APP_NAME') }}. All Rights Reserved</p>
            </div>
        </div>
        <!-- //footer -->

        <!-- mob -->
        <!-- end mob -->

        <!--banner Slider starts Here-->
        <script src="js/jquery-2.2.3.min.js"></script>
        <script src="js/responsiveslides.min.js"></script>
        <script>
            // You can also use "$(window).load(function() {"
            $(function() {
                // Slideshow 4
                $("#slider3").responsiveSlides({
                    auto: true,
                    pager: false,
                    nav: true,
                    speed: 500,
                    namespace: "callbacks",
                    before: function() {
                        $('.events').append("<li>before event fired.</li>");
                    },
                    after: function() {
                        $('.events').append("<li>after event fired.</li>");
                    }
                });

            });
        </script>
        <!-- js -->
        <!-- start-smoth-scrolling -->
        <script src="js/lightGallery.js"></script>
        <script>
            $(document).ready(function() {
                $("#lightGallery").lightGallery({
                    mode: "fade",
                    speed: 800,
                    caption: true,
                    desc: true,
                    mobileSrc: true
                });
            });
        </script>

        <script src="js/owl.carousel.js"></script>
        <link href="/css/owl.theme.css" rel="stylesheet">
        <link rel="stylesheet" href="/css/owl.carousel.css" type="text/css" media="all">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/mobile-detect/1.4.4/mobile-detect.min.js"></script>
        <script>
            $(document).ready(function() {
                var md = new MobileDetect(window.navigator.userAgent)

                //is mob

                if (md.mobile() != null) {
                    $('#pc-use').hide()
                } else {
                    $('.mob').hide()
                    $('.header').removeClass('user-login')
                }

                $("#owl-demo").owlCarousel({
                    autoPlay: 2000,
                    autoPlay: true,
                    navigation: true,
                    items: 4,
                    itemsDesktop: [640, 5],
                    itemsDesktopSmall: [414, 4],
                    navigationText: [
                        "<i class='fa fa-chevron-left'></i>",
                        "<i class='fa fa-chevron-right'></i>"
                    ]
                });

                $("#game-logo").owlCarousel({
                    autoPlay: 2000,
                    autoPlay: true,
                    navigation: true,
                    loop: true,
                    margin: 10,
                    responsive: false,
                    navigationText: [
                        "<i class='fa fa-chevron-left'></i>",
                        "<i class='fa fa-chevron-right'></i>"
                    ]
                });

            });
        </script>
        <!-- start-smoth-scrolling -->
        <script type="text/javascript" src="js/move-top.js"></script>
        <script type="text/javascript" src="js/easing.js"></script>
        <script type="text/javascript">
            jQuery(document).ready(function($) {
                $(".scroll").click(function(event) {
                    event.preventDefault();
                    $('html,body').animate({
                        scrollTop: $(this.hash).offset().top
                    }, 1000);
                });
            });
        </script>
        <!-- start-smoth-scrolling -->
        <!-- //js -->
        <script src="js/bootstrap.js"></script>
        <!-- //for bootstrap working -->
        <!-- here stars scrolling icon -->
        <script type="text/javascript">
            $(document).ready(function() {

                $('#loading').fadeOut();

                $().UItoTop({
                    easingType: 'easeOutQuart'
                });

                $('#checkAccount').click(function(e) {
                    const account = $('#account').val()
                    e.preventDefault();

                    $.ajax({
                        url: '/api/checkAccount',
                        data: {
                            account: account
                        },
                        type: 'GET',
                        success: function(res) {
                            if (res.status == 'success') {
                                alert('此帳號可以使用!')
                            } else {
                                alert(res.msg)
                            }
                        }
                    });
                });

                $('#sendPhoneCode').click(function(e) {
                    e.preventDefault();
                    const phone = $('#phone').val();
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: '/api/sendPhoneCode',
                        data: {
                            phone: phone,
                        },
                        type: 'POST',
                        success: function(res) {
                            if (res.status == 'success') {
                                alert('寄送成功　請查看手機簡訊!')
                            } else {
                                alert(res.msg)
                            }
                        }
                    });
                });

                $('#reg').click(function(e) {
                    e.preventDefault();
                    const data = $('#form').serialize();
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: '/api/web/user/reg',
                        data: data,
                        type: 'POST',
                        success: function(res) {
                            if (res.status == 'success') {
                                alert('註冊成功!')
                                location.reload()
                            } else {
                                alert(res.msg)
                            }
                        }
                    });
                });

                $('#login').click(function(e) {
                    e.preventDefault();
                    const data = $('#loginForm').serialize();
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: '/api/web/user/doLogin',
                        data: data,
                        type: 'POST',
                        success: function(res) {
                            if (res.status == 'success') {
                                alert('登入成功!')
                                location.reload()
                            } else {
                                alert(res.msg)
                            }
                        }
                    });
                });

            });
        </script>
</body>

</html>