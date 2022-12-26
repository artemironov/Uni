<!DOCTYPE html>
<html class="no-js" <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="preconnect" href="https://mc.yandex.ru">
	
	<?php wp_head(); ?>
    
    <link rel="apple-touch-icon" sizes="180x180" href="/wp-content/themes/uni/images/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/wp-content/themes/uni/images/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/wp-content/themes/uni/images/favicon/favicon-16x16.png">
    <!--<link rel="icon" href="/wp-content/themes/uni/images/favicon/favicon.ico" type="image/x-icon">-->
    <link rel="manifest" href="/wp-content/themes/uni/images/favicon/site.webmanifest">
    <link rel="mask-icon" href="/wp-content/themes/uni/images/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">
    
    <?php $ip = $_SERVER['REMOTE_ADDR'];
    $country_code = tabgeo_country_v4($ip);
    if( $country_code == US || $country_code == DE ) {} else { ?>
        <script>window.yaContextCb=window.yaContextCb||[]</script>
        <script src="https://yandex.ru/ads/system/context.js" async></script>
    <?php } ?>
</head>
<body <?php body_class() ?>>    
    <header id="header">
        <div class="head">
            <div class="menu-toggle"><span></span><span></span><span></span></div>
            <div class="logo">
                <a href="https://sultan-tv.ru"><img class="nolazy" width="160" height="32" src="/wp-content/themes/uni/images/logo.png" alt="Султан-тв"></a>
            </div>
            <div class="overmenu">
                <div class="closer mclose"></div>
                <?php wp_nav_menu(array('theme_location' => 'top-bar', 'container' => false, 'menu_class' => 'hmenu', )); ?>
                
                <ul class="soc-ul">
                    <li class="soc-search"><i class="icon-search"></i></li>
                    <li class="soc-yt"><a rel="noopener noreferrer nofollow" href="https://www.youtube.com/channel/UCexDuRshhanLukE-NlQlcJQ" target="_blank" title="Youtube"><i class="icon-youtube-play"></i></a></li>
                    <li class="soc-tg"><a rel="noopener noreferrer nofollow" href="https://t.me/suleymaniya" target="_blank" title="Телеграм"><i class="icon-paper-plane-1"></i></a></li>
                </ul>
            </div>
            <div class="hsearch"><i class="icon-search"></i></div>
        </div>
    </header>