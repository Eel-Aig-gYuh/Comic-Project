<!--
    nhảy đến trang truyện
-->

<?php
    session_start();


    require_once ('./database/connect_database.php');


    if(isset($_SESSION['user_id'])) {
        $sql = "select avatar from user where id = ".$_SESSION['user_id'];
        $user = EXECUTE_RESULT($sql);

        $sql = "SELECT * from notification where status = 'Chưa đọc' and id_user = ".$_SESSION['user_id']." order by created_at desc";
        $notification = EXECUTE_RESULT($sql);
    }


    $theloaitr = EXECUTE_RESULT("SELECT * FROM tag");
    $quocgiatr = EXECUTE_RESULT("SELECT * FROM country");

    $dieukien = "";
    $ktra = false;

    if(isset($_GET['cCompleted'])) {
        if($ktra) {$dieukien = $dieukien."or ";}
        else{$ktra=true;}
        $dieukien = $dieukien."str.status = 'Đã hoàn thành' ";
    }
    if(isset($_GET['cInProgress'])) {
        if($ktra) {$dieukien = $dieukien."or ";}
        else{$ktra=true;}
        $dieukien = $dieukien."str.status = 'Đang tiến hành' ";
    }
    if(isset($_GET['cDropped'])) {
        if($ktra) {$dieukien = $dieukien."or ";}
        else{$ktra=true;}
        $dieukien = $dieukien."str.status = 'Tạm ngưng' ";
    }

    foreach ($theloaitr as $item) {
        if(isset($_GET['tagid'.$item['id']])) {
            if($ktra) {$dieukien = $dieukien."or ";}
            else{$ktra=true;}
            $dieukien = $dieukien."stt.id_tag = ".$item['id']." ";
        }
    }
    foreach ($quocgiatr as $item) {
        if(isset($_GET['countryid'.$item['id']])) {
            if($ktra) {$dieukien = $dieukien."or ";}
            else{$ktra=true;}
            $dieukien = $dieukien."con.id = ".$item['id']." ";
        }
    }

    if($dieukien != "") {
        $dieukien = "where ".$dieukien." and str.status != 'Chờ duyệt' ";
    }
    else $dieukien = "where str.status != 'Chờ duyệt' ";


    $sql = "SELECT count(DISTINCT str.id) total FROM comic str JOIN country con on str.id_country = con.id LEFT JOIN tag_comic stt ON str.ID = stt.id_comic LEFT JOIN tag tg ON stt.id_tag = tg.ID ".$dieukien;
    $result = EXECUTE_RESULT($sql);

    if(count($result) == 0) {
        $total_records = 0;
    } else $total_records = $result[0]['total'];

    $current_page = isset($_GET['page']) ? $_GET['page'] : 1;
    $limit = 20;

    $total_page = ceil($total_records / $limit);

    if ($current_page > $total_page) {
        $current_page = $total_page;
    }
    else if ($current_page < 1) {
        $current_page = 1;
    }

    $start = ($current_page - 1) * $limit;
    $start = $start >= 0 ? $start : 0;

    $sql = "SELECT str.id, str.name, str.coverphoto, str.total_view, str.detail, str.total_chapter, str.rating, str.status, str.id_user, str.author, str.created_at, str.updated_at, count(DISTINCT fl.id_user) flow FROM comic str LEFT JOIN follow fl on str.id = fl.id_comic JOIN country con on str.id_country = con.id LEFT JOIN tag_comic stt ON str.id = stt.id_comic ".$dieukien." GROUP by str.id LIMIT $start, $limit";
    $comic = EXECUTE_RESULT($sql);

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
        <meta name="description" content="Đọc truyện tranh Manga, Manhua, Manhwa, Comic online hay và cập nhật thường xuyên tại TrongCarrot.com">
        <meta property="og:site_name" content="TrongCarrot.com">
        <meta name="Author" content="TrongCarrot.com">
        <meta name="keyword" content="doc truyen tranh, manga, manhua, manhwa, comic">
        <title>Đọc truyện tranh Manga, Manhua, Manhwa, Comic Online</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-uWxY/CJNBR+1zjPWmfnSnVxwRheevXITnMqoEIeG1LJrdI0GlVs/9cVSyPYXdcSF"
        crossorigin="anonymous">

        <link rel="stylesheet" type="text/css" href="./css/sidebar.css">
        <link rel="stylesheet" type="text/css" href="./css/footer.css">
        <link rel="stylesheet" type="text/css" href="./css/story-list-style.css">
        <link rel="stylesheet" type="text/css" href="./css/breadcrumb.css">
        <link rel="stylesheet" type="text/css" href="./css/pagination.css">
        <link rel="stylesheet" type="text/css" href="./css/topbar.css">
        <link rel="stylesheet" type="text/css" href="./css/category.css">
        <link rel="stylesheet" type="text/css" href="./css/TheLoai.css">

        <script language="javascript" src="http://code.jquery.com/jquery-2.0.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kQtW33rZJAHjgefvhyyzcGF3C5TFyBQBA13V1RKPf4uH+bwyzQxZ6CmMZHmNBEfJ"
        crossorigin="anonymous"></script>
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
    </head>

    <body>
        <style>
            .form_search {
                width: 500px;
                height: inherit;
            }
        </style>
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
                            <a href="./index.php" aria-current="page"><span itemprop="name">Trang
                                    chủ</span></a>
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

        <div id="content" class="container-xxl">
            <!-- Thanh breadcrumb -->
            <div class="contain_nav_breadvrumb">
                <nav  class="nav_breadcrumb" aria-label="Page breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item" aria-current="page"><i class='bx bxs-home'></i></li>
                        <li class="breadcrumb-item active">Thể loại</li>
                    </ol>
                </nav>
            </div>

            <!--The loai-->
            <div id="category-content">
                <form class="categories" id="The-loai">

                    <label class="caption">Thể loại</label>

                    <?php
                        foreach ($theloaitr as $item) {
                            echo '<div class="fcategory">
                            <input type="checkbox" name="tagid'.$item['id'].'" id="c'.$item['id'].'">
                            <label for="c'.$item['id'].'">'.$item['name'].'</label>
                            </div>';
                        }
                    ?>

                    <label class="caption" style="font-weight: bold;">Quốc gia</label>

                    <?php
                        foreach ($quocgiatr as $item) {
                            echo '<div class="fcategory">
                            <input type="checkbox" name="countryid'.$item['id'].'" id="c'.$item['id'].'">
                            <label for="c'.$item['id'].'">'.$item['name'].'</label>
                            </div>';
                        }
                    ?>

                    <label class="caption" style="font-weight: bold;">Tình trạng</label>

                    <div class="fcategory">
                        <input type="checkbox" name="cCompleted" id="cCompleted">
                        <label for="cCompleted">Đã hoàn thành</label>
                    </div>
                    <div class="fcategory">
                        <input type="checkbox" name="cInProgress" id="cInProgress">
                        <label for="cInProgress">Đang tiến hành</label>
                    </div>
                    <div class="fcategory">
                        <input type="checkbox" name="cDropped" id="cDropped">
                        <label for="cDropped">Tạm ngưng</label>
                    </div>
                </form>

                <button type="submit" id="search-story-input" onclick="submitForm()">Tìm kiếm</button>

            </div>

            <!-- <button id="xoa-bo-loc" style="display:inline-block;">Xóa bộ lọc</button> -->

            <div class="d-flex" style="justify-content: space-between; flex-direction: column; min-height: 1000px;"  id="contentDST-TL">
                <ul class="stories-list" id="0-SL">
                <?php
                    $index = 0;
                    foreach ($comic as $item) {
                        $inmoi = "";
                        $time = $item['created_at'];
                        $time = date_parse_from_format('Y-m-d H:i:s', $time);
                        $time_stamp = mktime($time['hour'],$time['minute'],$time['second'],$time['month'],$time['day'],$time['year']);
                        if(($now - $time_stamp) <= 7*24*60*60){
                            $inmoi = "<span class=\"badge bg-warning text-dark\">Mới</span>";
                        }
                        echo '<li class="story" id="0'.$index.'-story">
                        <div class="story-i-tag">
                            <span class="badge bg-info text-dark">'.$item['updated_at'].'</span>'.$inmoi.'
                        </div>
                        <a href="./comic.php?comic='.($item['id']).'">
                            <img src="'.$item['coverphoto'].'" alt="tk">
                            <h6 class="story-title">'.$item['name'].'</h6>
                        </a>
                        <p class="story-chapter"><a href="#">'.$item['total_chapter'].'</a></p>
                        <div class="story-info"  id="0'.($index++).'-story-info">
                            <h1 class="story-info-title">'.$item['name'].'</h1>
                            <p class="story-info-detail">Tình trạng truyện:'.$item['status'].'</p>
                            <p class="story-info-detail">Lượt xem: '.$item['total_view'].'</p>
                            <p class="story-info-detail">Lượt theo dõi: '.$item['flow'].'</p>
                            <div class="story-info-category">';
                        $sql = "select * from tag_comic str join tag tg on str.id_tag = tg.id where str.id_comic = ".$item['id'];
                        $theloai = EXECUTE_RESULT($sql);
                        foreach ($theloai as $tl) {
                            echo '<button class="category btn-outline-primary" onclick="location.href=\'./typecomic.php?tagid'.$tl['id'].'=on\';">'.$tl['name'].'</button>';
                        }
                        echo '</div>
                        <p class="story-info-detail">'.$item['detail'].'</p>
                        </div>
                        </li>';
                    }
                ?>
                </ul>

                <div class="contain_nav_pagination">
                    <nav class="nav_pagination" aria-label="Page navigation example">
                        <ul class="pagination">
                        <?php
                            // nếu current_page > 1 và total_page > 1 mới hiển thị nút prev
                            if ($current_page > 1 && $total_page > 1){
                                echo '<li class="page-item">
                                <a class="page-link" href="./history.php?page='.($current_page-1).'"><i class="bx bx-first-page"></i></a>
                                </li>';
                            }
                            if ($total_page > 1){
                                echo '<li class="page-item">
                                    <a class="page-link" href="./history.php?page=1" tabindex="-1" aria-disabled="true">Page 1</a>
                                </li>';
                            }
                            // Lặp khoảng giữa
                            for ($i = 2; $i <= $total_page; $i++){
                                // Nếu là trang hiện tại thì hiển thị thẻ span
                                // ngược lại hiển thị thẻ a
                                if ($i == $current_page){
                                    echo '<li class="page-item">
                                        <a class="page-link" href="./history.php?page='.$i.'" tabindex="-1" aria-disabled="true">Page '.$i.'</a>
                                    </li>';
                                }
                                else{
                                    echo '<li class="page-item">
                                        <a class="page-link" href="./history.php?page='.$i.'" tabindex="-1" aria-disabled="true">Page '.$i.'</a>
                                    </li>';
                                }
                            }

                            // nếu current_page < $total_page và total_page > 1 mới hiển thị nút prev
                            if ($current_page < $total_page && $total_page > 1){
                                echo '<li class="page-item">
                                <a class="page-link" href="./history.php?page='.($current_page+1).'"><i class="bx bx-last-page" ></i></a>
                                </li>';
                            }
                        ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>

        <button class="btntop" id="btntop">
            <i class='bx bx-send bx-rotate-270'></i>
        </button>

        <!--footer-->
        <footer class="site_footer">
            <div class="Grid" >
                <div class="Grid_row">
                    <div class="Grid_Column">
                        <h5 class="footer_heading" >About Us</h5>
                        <ul class="footer_list">
                            <li class="footer_item">
                                <a href="" class="footer_item_link">Đọc truyện miễn phí</a></li>
                            <li class="footer_item">
                                <a href="" class="footer_item_link">Hỗ trợ cho anh em đồng bào</a></li>
                            <li class="footer_item">
                                <a href="" class="footer_item_link">Tạo môi trường giao lưu</a></li>
                            <li class="footer_item">
                                <a href="" class="footer_item_link">Báo cáo</a></li>
                            <li class="footer_item">
                                <a href="" class="footer_item_link">Tải App</a></li>
                        </ul>
                    </div>

                    <div class="Grid_Column">
                        <h5 class="footer_heading">Contact Us</h5>
                        <ul class="footer_list">
                            <li class="footer_item">
                                <a href="" class="footer_item_link">Email: Trongcarrot@gmail.com</a> </li>
                            <li class="footer_item">
                                <a href="" class="footer_item_link">Liên hệ QC</a></li>
                            <li class="footer_item">
                                <a a href="" class="footer_item_link">Telephone Contact</a></li>
                            <li class="footer_item">
                                <a href="" class="footer_item_link"> <address>
                                    Địa chỉ
                                </address></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="footer_bottom">
                <div class="Grid">

                    <p class="footer_foot">&#169 2020 - Bản quyền thuộc về</p>

                </div>
            </div>
        </footer>

        <script language="JavaScript" src="./js/sidebarType1.js"></script>
        <script language="JavaScript" src="./js/jsheader.js"></script>
        <script language="JavaScript" src="./js/story-list.js"></script>
    </body>
</html>