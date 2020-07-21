<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <?php wp_head(); ?>
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, shrink-to-fit=no">
    <title><?php bloginfo('name'); ?><?php wp_title(); ?></title>
    <meta name="description" content="" />
	<meta name="keywords"  content="" />
    <link rel="icon" href="<?php bloginfo('template_directory') ?>/img/logo.png">
    <link rel="shortcut icon" href="<?php bloginfo('template_directory') ?>/img/logo.png">
    <meta property="og:title" content="">
    <meta property="og:description" content="">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="">
    <meta property="og:image" content="<?php bloginfo('template_directory') ?>/img/logo.png">
    <link rel="stylesheet" href="<?php bloginfo('template_directory') ?>/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php bloginfo('template_directory') ?>/css/bootstrap-reboot.min.css">
    <!-- slick -->
    <link rel="stylesheet" href="<?php bloginfo('template_directory') ?>/css/slick.css">
    <link rel="stylesheet" href="<?php bloginfo('template_directory') ?>/css/slick-theme.css">
    <!-- fonts -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.10.1/css/all.css"
          integrity="sha384-wxqG4glGB3nlqX0bi23nmgwCSjWIW13BdLUEYC4VIMehfbcro/ATkyDsF/AbIOVe" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700,800&display=swap" rel="stylesheet">
    <!-- main.css -->
    <link rel="stylesheet" href="<?php bloginfo('template_directory') ?>/css/main.css">
</head>
<body>
<header class="header">
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <a href="/"><img src="<?php bloginfo('template_directory') ?>/img/logo.png" alt="logo" class="logo"></a>
            </div>
            <div class="col-lg-4 ml-auto">
                <div class="phone d-flex">
                    <div class="phone__number d-flex align-items-center ml-auto">
                        <i class="fas fa-phone"></i>
                        <a href="tel:88005506465" class="phone__number-text">8 800 550 64 65</a>
                    </div>
                    <a href="#" class="btn heared_btn">Заказать звонок</a>
                </div>
            </div>
        </div>
    </div>
</header>
