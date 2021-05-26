<html>

<head>
    <title>Huisjes.nl - <?= $title ?></title>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://kit.fontawesome.com/e5272abace.js" crossorigin="anonymous"></script>

    <link href="Resources/CSS/style.css?time=<?= time(); ?>" rel="stylesheet" type="text/css" />
</head>

<body>
    <div class="overlay" style="opacity: 0; visibility: hidden;"></div>

    <div class="side-menu" style="left: 100%; visibility: hidden;">
        <div class="side-menu-header">
            <div class="cross center" onclick="CloseSideMenu()"><i class="fas fa-times"></i></div>
        </div>
        <div class="side-menu-main">
            <div class="menu-item"><a href="home">Home</a></div>
            <div class="menu-item"><a href="accommodations">Accommodaties</a></div>
        </div>
    </div>

    <div class="banner <?= $title == 'Home' ? 'home' : '' ?>">
        <div class="curve">
            <div style="height: 100%; width: 100%; overflow: hidden;"><svg viewBox="0 0 500 150" preserveAspectRatio="none" style="height: 100%; width: 100%;">
                    <path d="M0.00,49.99 C190.96,118.71 349.20,-49.99 500.00,49.99 L500.00,150.00 L0.00,150.00 Z" style="stroke: none; fill: #fff;"></path>
                </svg></div>
        </div>
    </div>

    <div class="header">
        <div class="logo center">Huisjes.nl</div>
        <div class="menu-bars center" onclick="OpenSideMenu()"><i class="fas fa-bars"></i></div>
        <div class="menu center">
            <a href="home">
                <div class="m-item">Home</div>
            </a>
            <a href="accommodations">
                <div class="m-item">Accommodaties</div>
            </a>
        </div>
    </div>