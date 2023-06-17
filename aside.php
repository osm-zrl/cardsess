<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('location:login.php');
    die('pas connecter!');
}
if (isset($_GET['log_out'])) {
    session_destroy();
    session_abort();
    header('location:login.php');
}
?>

<style>
    .fa-2x {
        font-size: 2em;
    }

    .fa {
        position: relative;
        display: table-cell;
        width: 60px;
        height: 36px;
        text-align: center;
        vertical-align: middle;
        font-size: 20px;
    }


    .main-menu:hover,
    nav.main-menu.expanded {
        width: 250px;
        overflow: visible;
    }

    .main-menu {
        background: #fff;
        border-right: 1px solid #e5e5e5;
        position: absolute;
        top: 0;
        bottom: 0;
        height: 100%;
        left: 0;
        width: 60px;
        overflow: hidden;
        -webkit-transition: width .05s linear;
        transition: width .05s linear;
        z-index: 1000;
        transition: 0.3s;
    }

    .main-menu>ul {
        margin: 30px 0;
    }

    .main-menu li {
        position: relative;
        display: block;
        width: 250px;
    }

    .main-menu li>a,
    .outBtn {
        position: relative;
        display: table;
        border-collapse: collapse;
        border-spacing: 0;
        color: #999;
        font-family: arial;
        font-size: 14px;
        text-decoration: none;
        -webkit-transition: all .1s linear;
        transition: all .1s linear;
        font-weight: bold;

    }

    .main-menu .nav-icon {
        position: relative;
        display: table-cell;
        width: 60px;
        height: 36px;
        text-align: center;
        vertical-align: middle;
        font-size: 18px;
    }

    .main-menu .nav-text {
        position: relative;
        display: table-cell;
        vertical-align: middle;
        width: 190px;
        font-family: 'Titillium Web', sans-serif;
    }

    .main-menu>ul.logout {
        position: absolute;
        left: 0;
        bottom: 0;
    }

    .no-touch .scrollable.hover {
        overflow-y: hidden;
    }

    .no-touch .scrollable.hover:hover {
        overflow-y: auto;
        overflow: visible;
    }

    a:hover,
    a:focus {
        text-decoration: none;
    }

    nav {
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        -o-user-select: none;
        user-select: none;
    }

    nav ul,
    nav li,
    .outBtn {
        outline: 0;
        margin: 10px 0;
        padding: 0;
    }

    .outBtn,
    .main-menu li:hover>a,
    nav.main-menu li.active>a,
    .dropdown-menu>li>a:hover,
    .dropdown-menu>li>a:focus,
    .dropdown-menu>.active>a,
    .dropdown-menu>.active>a:hover,
    .dropdown-menu>.active>a:focus,
    .no-touch .dashboard-page nav.dashboard-menu ul li:hover a,
    .dashboard-page nav.dashboard-menu ul li.active a {
        color: #153090;
        background-color: #e1e7ff;
    }

    .area {
        float: left;
        background: #e2e2e2;
        width: 100%;
        height: 100%;
    }

    @font-face {
        font-family: 'Titillium Web';
        font-style: normal;
        font-weight: 300;
        src: local('Titillium WebLight'), local('TitilliumWeb-Light'), url(http://themes.googleusercontent.com/static/fonts/titilliumweb/v2/anMUvcNT0H1YN4FII8wpr24bNCNEoFTpS2BTjF6FB5E.woff) format('woff');
    }

    .pic {
        width: 55px;
        position: relative;
        display: table-cell;
        text-align: center;
        vertical-align: middle;
        font-size: 20px;
        margin-left: 2.5px;
    }
</style>


<aside>

    <nav class="main-menu">
        <ul>
            <li class="navlg">

                <i class="pic x "><img src="img/Logo_ofppt.png" class="pic x" alt=""></i>

                <span class="nav-text fw-bold">
                    &nbsp;CardSESS
                </span>

            </li>

            <li>
                <a href="index.php">
                    <i class="fa fa-home fa-2x"></i>
                    <span class="nav-text">
                        Dashboard
                    </span>
                </a>

            </li>
            <li class="has-subnav">
                <a href="class.php">
                    <i class="fa fa-solid fa-landmark"></i>

                    <span class="nav-text">
                        classrooms
                    </span>
                </a>

            </li>
            <li class="has-subnav">
                <a href="students.php">
                    <i class="fa fa-users fa-2x"></i>
                    <span class="nav-text">
                        Students
                    </span>
                </a>

            </li>
            <li class="has-subnav">
                <a href="cards.php">
                    <i class="fa fa-address-card fa-2x"></i>
                    <span class="nav-text">
                        Cards
                    </span>
                </a>

            </li>

            <li class="has-subnav nav-item dropdown">
                <a href="" class="dropdown-toggle" role="button"  data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <i class="fa fa-solid fa-clock"></i>
                    &nbsp;
                    <span class="nav-text">
                        Manage Sessions
                    </span>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item text-center py-2" style="font-size:17px;" href="#">Ongoing sessions</a></li>
                    <li><a class="dropdown-item text-center py-2" style="font-size:17px;" href="upsessions.php">Upcoming sessions</a></li>
                    <li><a class="dropdown-item text-center py-2" style="font-size:17px;" href="presessions.php">Previous sessions</a></li>
                </ul>


            </li>
            <li class="has-subnav">
                <a href="presence.php">
                    <i class="fa fa-solid fa-wifi"></i>
                    <span class="nav-text">
                        Live Entry
                    </span>
                </a>

            </li>

            <li class="has-subnav">
                <a href="presence_log.php">
                    <i class="fa fa-solid fa-table-list"></i>

                    <span class="nav-text">
                        Presence Log
                    </span>
                </a>

            </li>



        </ul>

        <ul class="logout">
            <li>
                <form method="GET" class="d-flex flex-row">
                    <button class="outBtn" name="log_out" style="border:none; background:transparent; padding:0;">
                        <i class="fa fa-power-off fa-2x"></i>
                        <span class="nav-text">
                            Logout
                        </span>
                    </button>
                </form>

            </li>
        </ul>
    </nav>
</aside>