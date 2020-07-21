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
    <link rel="shortcut icon" href="<?php bloginfo('template_directory') ?>/img/favicon.png">
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

    <link rel="stylesheet" href="<?php bloginfo('template_directory') ?>/css/media.css">
    <!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-146652343-1"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'UA-146652343-1');
	</script>
		<!-- Yandex.Metrika counter -->
	<script type="text/javascript" >
	   (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
	   m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
	   (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

	   ym(55103425, "init", {
	        clickmap:true,
	        trackLinks:true,
	        accurateTrackBounce:true,
	        webvisor:true
	   });
	</script>
	<noscript><div><img src="https://mc.yandex.ru/watch/55103425" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
	<!-- /Yandex.Metrika counter -->						
</head>
<body>
<?php if ((is_page('8'))) { ?>
<header class="header">
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <a href="/" class="link__logo"><img src="<?php bloginfo('template_directory') ?>/img/logo.png" alt="logo" class="logo"></a>
            </div>
            <div class="col-md-7 ml-auto">
                <div class="phone d-flex">
                    <div class="phone__number d-flex align-items-center">
                        <i class="fas fa-phone"></i>
                        <a href="tel:88005506465" class="phone__number-text">8 800 550 64 65</a>
                    </div>
                    <a href="#modal" class="btn heared_btn open_modal">Заказать звонок</a>
                </div>
            </div>
        </div>
    </div>
</header>
 <?php } ?>
 
