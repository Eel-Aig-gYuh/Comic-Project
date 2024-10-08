<?php
    session_start();
    require_once ('./database/connect_database.php');

    if(isset($_SESSION['user_id'])) {
        $sql = "select avatar from user where id = ".$_SESSION['user_id'];
        $user = EXECUTE_RESULT($sql);

        $sql = "SELECT * from NOTIFICATION where status = 'Chưa đọc' and id_user = ".$_SESSION['user_id']." order by created_at desc";
        $notification = EXECUTE_RESULT($sql);
    }

    $now = time();
?>

<!DOCTYPE html>
<html lang="en">

<head itemscope="itemscope" itemtype="http://schema.org/WebSite">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Đọc truyện tranh Manga, Manhua, Manhwa, Comic online hay và cập nhật thường xuyên tại TrongCarrot.com">
    <meta property="og:site_name" content="TrongCarrot.com">
    <meta name="Author" content="TrongCarrot.com">
    <meta name="keyword" content="doc truyen tranh, manga, manhua, manhwa, comic">
    <title>Đọc truyện tranh Manga, Manhua, Manhwa, Comic Online</title>
    <link href='https://fonts.googleapis.com/css?family=Roboto' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="./css/topbar.css">
    <link rel="stylesheet" type="text/css" href="./css/sidebar.css">
    <link rel="stylesheet" type="text/css" href="./css/story-list-style.css">
    <link rel="stylesheet" type="text/css" href="./css/footer.css">
    <link rel="stylesheet" type="text/css" href="./css/style-home.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kQtW33rZJAHjgefvhyyzcGF3C5TFyBQBA13V1RKPf4uH+bwyzQxZ6CmMZHmNBEfJ" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <style id="global-styles-inline-css" type="text/css">
    </style>
    <link rel="stylesheet" id="fonts-roboto-css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700"
        type="text/css" media="all">
    <link rel="stylesheet" id="fontsawesome-css" href="https://use.fontawesome.com/releases/v5.9.0/css/all.css"
        type="text/css" media="all">
    <link rel="stylesheet" id="theme-light-css" href="./css/header.css" type="text/css" media="all">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style type="text/css">
    @media only screen and (max-width: 769px) {

        .header-area,
        a#east_logout {
            background: linear-gradient(90deg, rgba(242,242,143,1) 0%, rgba(246,164,121,1) 35%, rgba(252,119,49,1) 100%);
        }
    }

    @media only screen and (max-width: 769px) {}
    </style>
    <style type="text/css" id="wp-custom-css">
    #primary-menu .container .logo img {
        width: 160%;
        height: auto;
        margin-left: -40px;
    }
    .logo img {
        /* max-height: 120px; */
        margin-top: -15px;
    }
    </style>

    <script language="javascript">
    function danh_dau_da_doc() {
        $data = "danh-dau-da-doc";
        $.ajax({
            url: "notification.php",
            type: "post",
            dataType: "text",
            data: {
                data: $data
            },
            success: function(result) {
                $('#notification-button').html(result);
            }
        });
    }
    </script>
    <script data-cfasync="false" async="" type="text/javascript"></script>
    <script src="https://cdn.onesignal.com/sdks/OneSignalPageSDKES6.js?v=151605" async="">
    </script>
    <link rel="stylesheet" href="https://onesignal.com/sdks/OneSignalSDKStyles.css?v=2">
    <script type='text/javascript' src='https://pl23162420.highcpmgate.com/26/f1/ca/26f1ca05634ee764de5a63adc49ff5a8.js'></script>
    <script type='text/javascript' src='https://pl23169432.highcpmgate.com/7e/55/26/7e552684b762d2f00eed6c0a6ee8e5da.js'></script>
    <script type="text/javascript">
	    atOptions = {
		    'key' : '321093dcf41c3e57a255b9cd0511729f',
		    'format' : 'iframe',
		    'height' : 60,
		    'width' : 468,
		    'params' : {}
	};
    </script>
    <script type="text/javascript" src="https://www.topcreativeformat.com/321093dcf41c3e57a255b9cd0511729f/invoke.js"></script>
</head>

<body class="blog bodyclass" itemscope="itemscope" itemtype="http://schema.org/WebPage">
    <style>
    .form_search {
        max-width: 500px;
        height: inherit;
    }
    </style>
    <!--header-->

    <header id="masthead" class="site-header" role="banner" itemscope="itemscope" itemtype="http://schema.org/WPHeader">
            <?php
                    if (isset($_SESSION['user_id'])) {
                        echo '<style>
                        #chua-dang-nhap {
                            display: none;
                        }
                        </style>';
                    } else {
                        echo '<style>
                        #da-dang-nhap, #da-duoc-dang-nhap {
                            display: none;
                        }
                        </style>';
                    }
            ?>
            <div id="ad-overlay" style="
                    display: grid;
                    grid-template-columns: repeat(4, 1fr);
                    grid-template-rows: repeat(4, 1fr);
                    width: 100vw;
                    height: 100vh;
                    position: fixed;
                    top: 0;
                    left: 0;
                    z-index: 999;
                ">
        </div>
        <script>
            const adOverlay = document.getElementById('ad-overlay');
            const adOverlayLink = adOverlay.querySelector('a');

            adOverlay.addEventListener('click', (event) => {

            // Ẩn thẻ div
            adOverlay.style.display = 'none';
            });
        </script>
        <div class="header-area mobile-area">
            <div class="container">
                <div class="btnmenu"><span class="fa fa-bars"></span></div>
                <div class="logo-area">
                    <div itemscope="itemscope" itemtype="http://schema.org/Brand" class="site-branding logox">
                        <h1 class="logo">
                            <a title="Trồng cà rốt" itemprop="url" href="./index.php"><img src="./img/image.png"
                                    alt="Trồng cà rốt" data-src="./img/image.png" decoding="async"
                                    class="lazyload" data-eio-rwidth="3000" data-eio-rheight="757"><noscript><img src='./img/image.png'
                                        alt='Trồng cà rốt' data-eio="l" /></noscript><span
                                    class="hdl">Trồng cà rốt</span></a>
                        </h1>
                        <meta itemprop="name" content="Trồng cà rốt">
                    </div>
                </div>
                <div class="theme switchmode"> <label class="switch"><input type="checkbox"> <span
                            class="slider round"></span></label> <span class="text"><i class="fas fa-sun"></i> / <i
                            class="fas fa-moon"></i></span></div>
                <div class="accont">
                    <a href="./login.php" class="showlogin" id="east_logout"><span class="fa fa-user"></span></a>
                </div>
                <div class="btnsearch"><a class="aresp search-resp"><i class="fa fa-search"></i></a></div>
            </div>
        </div>
        <div id="primary-menu" class="mm">
            <div class="mobileswl">
                <div class="accont">
                    <a href="./login.php" class="showlogin" id="east_logout"><span class="fa fa-user"></span></a>
                </div>
                <div class="switch"> <span class="inner-switch"><i class="fas fa-moon" aria-hidden="true"></i></span>
                </div>
            </div>
            <div class="container">
                <div class="header-area desktop-area">
                    <div class="btnmenu"><span class="fa fa-bars"></span></div>
                    <div class="logo-area">
                        <div itemscope="itemscope" itemtype="http://schema.org/Brand" class="site-branding logox">
                            <h1 class="logo">
                                <a title="Trồng cà rốt" itemprop="url" href="./index.php">
                                    <img src="./img/image.png" alt="Trồng cà rốt" data-src="./img/image.png" decoding="async"
                                        class=" ls-is-cached lazyloaded" data-eio-rwidth="3000" data-eio-rheight="757">
                                    <noscript>
                                        <img src='./img/image.png' alt='Trồng cà rốt' data-eio="l" />
                                    </noscript>
                                    <span class="hdl">Trồng cà rốt</span>
                                </a>
                            </h1>
                            <meta itemprop="name" content="Trồng cà rốt">
                        </div>
                    </div>
                    <div class="theme switchmode"> <label class="switch"><input type="checkbox"> <span
                                class="slider round"></span></label> <span class="text"><i class="fas fa-sun"></i> / <i
                                class="fas fa-moon"></i></span></div>
                    <div class="accont">
                        <a href="./login.php" class="showlogin" id="east_logout"><span class="fa fa-user"></span></a>
                    </div>
                    <div class="search_desktop">
                        <form action="./search.php" id="form" method="get">
                            <input id="s" type="text" placeholder="Search..." name="search" autocomplete="off">
                            <button type="submit" id="submit" class="search-button"><span
                                    class="fa fa-search"></span></button>
                        </form>
                        <div class="live-search ltr" style="display: none;"></div>
                    </div>
                    <div class="btnsearch"><a class="aresp search-resp"><i class="fa fa-search"></i></a></div>
                </div>
                <nav id="site-navigation" role="navigation" itemscope="itemscope"
                    itemtype="http://schema.org/SiteNavigationElement">
                    <ul id="menu-trang-chu" class="menu">
                    <li id="menu-item-65"
                            class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item current_page_item menu-item-home menu-item-65">
                            <a href="./index.php" aria-current="page"><span itemprop="name">Trangchủ</span></a>
                        </li>
                        <li id="menu-item-68"
                            class="menu-item menu-item-type-custom menu-item-object-custom menu-item-68"><a
                                href="https://www.facebook.com/profile.php?id=61553276407828&mibextid=ZbWKwL"><span itemprop="name">Facebook</span></a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <div class="search_responsive">
            <form method="get" id="form-search-resp" class="form-resp-ab" action="./search.php"> <input type="text"
                    placeholder="Search..." name="s" id="ms" value="" autocomplete="off"> <button type="submit"
                    class="search-button"><span class="fa fa-search"></span></button></form>

        </div>
    </header>
    <script type="text/javascript"
        src="./js/header.js"
        id="front-script-js"></script>

    <!--test banner mới-->

    <div id="banner-top" class="container-xxl">

        <!--slider start-->
        <div class="slider">
            <div class="slides">
                <input type="radio" name="radio-btn" id="radio1">
                <input type="radio" name="radio-btn" id="radio2">
                <input type="radio" name="radio-btn" id="radio3">
                <input type="radio" name="radio-btn" id="radio4">
                <input type="radio" name="radio-btn" id="radio5">
                <!--slider end-->

                <!--banner start-->
                <?php
                        $sql = "select cm.name, cm.status, cm.total_view, cm.coverphoto, cm.detail, cm.id idcomic, count(fl.id_user) tdoi from comic cm left join follow fl on cm.id = fl.id_comic where cm.status != 'Chờ duyệt' GROUP by cm.id limit 5";
                        $truyen_banner = EXECUTE_RESULT($sql);

                        $index = 1;
                        foreach ($truyen_banner as $item) {
                            $abc = "banner first";
                            if($index != 1) $abc = "banner";
                            echo '<div class="'.$abc.'" id="banner-'.($index++).'">
                            <img src="'.($item['coverphoto']).'" onclick="location.href=\'./comic.php?comic='.($item['idcomic']).'\'" style="cursor: pointer;">
                            <div class="banner-info">
                                <h1 class="banner-info-title">'.($item['name']).'</h1>
                                <p class="banner-info-detail">Tình trạng truyện: '.($item['status']).'</p>
                                <p class="banner-info-detail">Lượt xem: '.($item['total_view']).'</p>
                                <p class="banner-info-detail">Lượt theo dõi: '.($item['tdoi']).'</p>
                                <div class="story-info-category">';

                            $sql = "select * from tag_comic str join tag tg on str.id_tag = tg.id where str.id_comic = ".$item['idcomic'];
                            $theloai = EXECUTE_RESULT($sql);
                            foreach ($theloai as $tl) {
                                echo '<button class="category btn-outline-primary" onclick="location.href=\'./typecomic.php?tagid'.$tl['id'].'=on\';">'.$tl['name'].'</button>';
                            }

                            echo '</div>
                                <p class="banner-info-detail">'.($item['detail']).'</p>
                            </div>
                            </div>';
                        }
                    ?>
                <!--banner end-->

                <!--auto navigation start-->
                <div class="auto-navigation">
                    <div class="auto-btn1"></div>
                    <div class="auto-btn2"></div>
                    <div class="auto-btn3"></div>
                    <div class="auto-btn4"></div>
                    <div class="auto-btn5"></div>
                </div>
                <!--auto navigation end-->
            </div>

            <!--manual navigation start-->
            <div class="manual-navigation">
                <label for="radio1" class="manual-btn" onclick="set_counter(1)"></label>
                <label for="radio2" class="manual-btn" onclick="set_counter(2)"></label>
                <label for="radio3" class="manual-btn" onclick="set_counter(3)"></label>
                <label for="radio4" class="manual-btn" onclick="set_counter(4)"></label>
                <label for="radio5" class="manual-btn" onclick="set_counter(5)"></label>
            </div>
            <!--manual navigation end-->
        </div>

        <!--3 children ngoai banner-->
        <button class="change-banner-button bi bi-chevron-compact-left" type="button" style="top: 40%; right: 101%;"
            id="previous-banner-f" onclick="previous_bannerf()">
        </button>

        <button class="change-banner-button bi bi-chevron-compact-right" type="button" style="top: 40%; left: 101%;"
            id="previous-banner-f" onclick="next_bannerf()">
        </button>

        <script>

        var counter = 1;

        function play_banner() {
            if (counter > 5) counter = 1;
            if (counter < 1) counter = 5;
            document.getElementById('radio' + counter).checked = true;
            counter++;
        }

        var bannertimer

        function set_counter(index) {
            counter = index;
            clearInterval(bannertimer);
            play_banner();
            bannertimer = setInterval(play_banner, 5000);
        }

        play_banner();
        bannertimer = setInterval(play_banner, 5000);

        function next_bannerf() {
            clearInterval(bannertimer);
            play_banner();
            bannertimer = setInterval(play_banner, 5000);
        }

        function previous_bannerf() {
            clearInterval(play_banner);
            counter = counter - 2;
            play_banner();
            myBanner_play = setInterval(myTimer, 5000);
        }
        </script>

    </div>

    <!--Story list TRUYEN MOI NHAT -->
    <div class="container-xxl" id="contentTC">
        <!--Story list 0-->
        <ul class="stories-list" id="0-SL">
            <h1 class="caption">Truyện mới nhất</h1>
            <?php
                    $sql = "select cm.updated_at, cm.total_chapter, cm.created_at, cm.name, cm.status, cm.total_view, cm.coverphoto, cm.detail, cm.id idcomic, count(fl.id_user) tdoi from comic cm left join follow fl on cm.id = fl.id_comic where cm.status != 'Chờ duyệt' GROUP by cm.id ORDER BY cm.updated_at DESC LIMIT 10";

                    $truyen_banner = EXECUTE_RESULT($sql);

                    $index = 1;
                    foreach ($truyen_banner as $item) {
                        $inmoi = "";
                        $time = $item['created_at'];
                        $time = date_parse_from_format('Y-m-d H:i:s', $time);
                        $time_stamp = mktime($time['hour'],$time['minute'],$time['second'],$time['month'],$time['day'],$time['year']);
                        if(($now - $time_stamp) <= 7*24*60*60){
                            $inmoi = "<span class=\"badge bg-warning text-dark\">Mới</span>";
                        }
                        echo '<li class="story" id="0'.($index).'-story">
                        <div class="story-i-tag">
                            <span class="badge bg-info text-dark">'.($item['updated_at']).'</span>'.$inmoi.'
                        </div>
                        <a href="./comic.php?comic='.($item['idcomic']).'">
                            <img src="'.($item['coverphoto']).'" alt="tk">
                            <h6 class="story-title">'.($item['name']).'</h6>
                        </a>
                        <p class="story-chapter"><a href="#">'.($item['total_chapter']).'</a></p>
                        <div class="story-info"  id="0'.($index++).'-story-info">
                            <h1 class="story-info-title">'.($item['name']).'</h1>
                            <p class="story-info-detail">Tình trạng truyện: '.($item['status']).'</p>
                            <p class="story-info-detail">Lượt xem: '.($item['total_view']).'</p>
                            <p class="story-info-detail">Lượt theo dõi: '.($item['tdoi']).'</p>
                            <div class="story-info-category">';

                        $sql = "select * from tag_comic str join tag tg on str.id_tag = tg.id where str.id_comic = ".$item['idcomic'];
                        $theloai = EXECUTE_RESULT($sql);
                        foreach ($theloai as $tl) {
                            echo '<button class="category btn-outline-primary" onclick="location.href=\'./typecomic.php?tagid'.$tl['id'].'=on\';">'.$tl['name'].'</button>';
                        }

                        echo '</div>
                            <p class="story-info-detail">'.($item['detail']).'</p>
                        </div>
                    </li>';
                    }

                ?>

            <div style="width: 100%">
                <a href="./updated.php" class="row open-list">Xem thêm</a>
            </div>
        </ul>
    </div>
    <div class="container-xxl" id="contentTC">
        <!--story list TRUYEN NHIEU NGUOI XEM NHAT -->
        <ul class="stories-list" id="1-SL">
            <h1 class="scaption">Truyện nhiều lượt xem nhất</h1>

            <?php
                    $sql = "select cm.total_chapter, cm.created_at, cm.updated_at, cm.name, cm.status, cm.total_view, cm.coverphoto, cm.detail, cm.id idcomic, count(fl.id_user) tdoi from comic cm left join follow fl on cm.id = fl.id_comic where cm.status != 'Chờ duyệt' GROUP by cm.id ORDER BY cm.total_view DESC LIMIT 10";
                    $truyen_banner = EXECUTE_RESULT($sql);

                    $index = 0;
                    foreach ($truyen_banner as $item) {
                        $inmoi = "";
                        $time = $item['created_at'];
                        $time = date_parse_from_format('Y-m-d H:i:s', $time);
                        $time_stamp = mktime($time['hour'],$time['minute'],$time['second'],$time['month'],$time['day'],$time['year']);
                        if(($now - $time_stamp) <= 7*24*60*60){
                            $inmoi = "<span class=\"badge bg-warning text-dark\">Mới</span>";
                        }
                        echo '<li class="story" id="1'.($index).'-story">
                    <div class="story-i-tag">
                        <span class="badge bg-info text-dark">'.($item['updated_at']).'</span>'.$inmoi.'
                    </div>
                    <a href="./comic.php?comic='.($item['idcomic']).'">
                        <img src="'.($item['coverphoto']).'" alt="tk">
                        <h6 class="story-title">'.($item['name']).'</h6>
                    </a>
                    <p class="story-chapter"><a href="#">'.($item['total_chapter']).'</a></p>
                    <div class="story-info"  id="1'.($index++).'-story-info">
                        <h1 class="story-info-title">'.($item['name']).'</h1>
                        <p class="story-info-detail">Tình trạng truyện: '.($item['status']).'</p>
                        <p class="story-info-detail">Lượt xem: '.($item['total_view']).'</p>
                        <p class="story-info-detail">Lượt theo dõi: '.($item['tdoi']).'</p>
                        <div class="story-info-category">';

                        $sql = "select * from tag_comic str join tag tg on str.id_tag = tg.id where str.id_comic = ".$item['idcomic'];
                        $theloai = EXECUTE_RESULT($sql);
                        foreach ($theloai as $tl) {
                            echo '<button class="category btn-outline-primary" onclick="location.href=\'./typecomic.php?tagid'.$tl['id'].'=on\';">'.$tl['name'].'</button>';
                        }

                        echo '</div>
                        <p class="story-info-detail">'.($item['detail']).'</p>
                    </div>
                    </li>';
                    }

                ?>

            <!-- <div style="width: 100%">
                    <a href="#" class="open-list">Xem thêm</a>
                </div> -->
        </ul>
    </div>



    <!--side bar-->
    <!-- Thanh công cụ -->
    <div class="sidebar">
        <div class="logo-detail" style="background-color: #f8edf5;">
            <i class='bx bx-menu' id="btn-menu"></i>
        </div>
        <ul class="nav-list">
            <li>
                <a href="./">
                    <i class='bx bxs-home'></i>
                    <span class="links_name">Trang chủ</span>
                </a>
                <span class="tooltip">Trang chủ</span>
            </li>
            <li>
                <a href="./typecomic.php">
                    <i class='bx bxs-purchase-tag'></i>
                    <span class="links_name">Thể loại</span>
                </a>
                <span class="tooltip">Thể loại</span>
            </li>
            <li>
                <a href="./updated.php">
                    <i class='bx bxs-hourglass'></i>
                    <span class="links_name">Mới cập nhật</span>
                </a>
                <span class="tooltip">Mới cập nhật</span>
            </li>
            <li>
                <a href="./following.php">
                    <i class='bx bxs-heart'></i>
                    <span class="links_name">Theo dõi</span>
                </a>
                <span class="tooltip">Theo dõi</span>
            </li>
            <li>
                <a href="./history.php">
                    <i class='bx bx-history'></i>
                    <span class="links_name">Lịch sử đọc</span>
                </a>
                <span class="tooltip">Lịch sử đọc</span>
            </li>
            <li id="btn-light-dark">
                <a>
                    <i class='bx bxs-bulb'></i>
                    <span class="links_name">Bật/Tắt đèn</span>
                </a>
                <span class="tooltip">Bật/Tắt đèn</span>
            </li>
            <li id="chua-dang-nhap">
                <a href="./login.php">
                    <i class='bx bx-log-in'></i>
                    <span class="links_name">Đăng Nhập</span>
                </a>
                <span class="tooltip">Đăng nhập</span>
            </li>

            <li id="chua-dang-nhap">
                <a href="./register.php">
                    <i class='bx bxs-user-plus'></i>
                    <span class="links_name">Đăng Ký</span>
                </a>
                <span class="tooltip">Đăng ký</span>
            </li>


            <li id="da-dang-nhap">
                <a href="./account.php">
                    <i class='bx bxs-user-detail'></i>
                    <span class="links_name">Quản lý thông tin tài khoản</span>
                </a>
                <span class="tooltip">Quản lý thông tin tài khoản</span>
            </li>


            <li id="da-dang-nhap">
                <a href="./mycomic.php">
                    <i class='bx bxs-folder-plus'></i>
                    <span class="links_name">Quản lý truyện đã đăng</span>
                </a>
                <span class="tooltip">Quản lý truyện đã đăng</span>
            </li>


            <li id="da-dang-nhap">
                <a href="./logout.php">
                    <i class='bx bx-log-out'></i>
                    <span class="links_name">Đăng xuất</span>
                </a>
                <span class="tooltip">Đăng xuất</span>
            </li>
        </ul>
    </div>

    <button class="btntop" id="btntop">
        <i class='bx bx-send bx-rotate-270'></i>
    </button>

    <!--tam thoi xoa truyen khoi danh sach-->
    <script>
    function delete_story(element_id) {
        document.getElementById(element_id + "-story").classList.add("d-none")
    }
    </script>


    <!--footer-->
    <footer class="site_footer">
        <div class="Grid">
            <div class="Grid_row">

                <div class="Grid_Column">
                    <h5 class="footer_heading">About Us</h5>
                    <ul class="footer_list">
                        <li class="footer_item">
                            <a href="" class="footer_item_link">Đọc truyện miễn phí</a>
                        </li>
                        <li class="footer_item">
                            <a href="" class="footer_item_link">Hỗ trợ cho anh em đồng bào</a>
                        </li>
                        <li class="footer_item">
                            <a href="" class="footer_item_link">Tạo môi trường giao lưu</a>
                        </li>
                        <li class="footer_item">
                            <a href="" class="footer_item_link">Báo cáo</a>
                        </li>
                        <li class="footer_item">
                            <a href="" class="footer_item_link">Tải App</a>
                        </li>
                    </ul>
                </div>

                <div class="Grid_Column">
                    <h5 class="footer_heading">Contact Us</h5>
                    <ul class="footer_list">
                        <li class="footer_item">
                            <a href="" class="footer_item_link">Email: Trongcarrot@gmail.com</a>
                        </li>
                        <li class="footer_item">
                            <a href="" class="footer_item_link">Liên hệ QC</a>
                        </li>
                        <li class="footer_item">
                            <a a href="" class="footer_item_link">Telephone Contact</a>
                        </li>
                        <li class="footer_item">
                            <a href="" class="footer_item_link">
                                <address>
                                    Địa chỉ
                                </address>
                            </a>
                        </li>

                    </ul>
                </div>

            </div>
        </div>
        <div class="footer_bottom">
            <div class="Grid">
                <p class="footer_foot">&#169 2020 - Bản quyền thuộc về </p>
            </div>
        </div>
    </footer>

    <script language="JavaScript" src="./js/sidebarType1.js"></script>
    <script language="JavaScript" src="./js/jsheader.js"></script>
    <script language="JavaScript" src="./js/story-list.js"></script>
</body>

</html>
