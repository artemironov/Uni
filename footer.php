<footer id="footer">
    <div class="container">
        <div class="row foot">
            <div class="col-lg-4">
                <?php wp_nav_menu(array('theme_location' => 'bot-bar', 'container' => false, 'menu_class' => 'fmenu', )); ?>
            </div>
            <div class="col-lg-4">
                <div class="logo">
                    <a href="https://sultan-tv.ru"><img class="nolazy" width="160" height="32" src="/wp-content/themes/uni/images/logo.png" alt="Султан-тв"></a>
                </div>
            </div>
            <div class="col-lg-4">
                <ul class="soc-ul">
                    <li class="soc-search"><i class="icon-search"></i></li>
                    <li class="soc-yt"><a rel="noopener noreferrer nofollow" href="https://www.youtube.com/channel/UCexDuRshhanLukE-NlQlcJQ" target="_blank" title="Youtube"><i class="icon-youtube-play"></i></a></li>
                    <li class="soc-tg"><a rel="noopener noreferrer nofollow" href="https://t.me/suleymaniya" target="_blank" title="Телеграм"><i class="icon-paper-plane-1"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="fcopy">© 2018 - <?php echo date('Y'); ?> СУЛТАН TV - любое копирование материалов сайта строго запрещено</div>
    </div>
</footer>

<div id="scroll-to-top">
	<span>Наверх</span>
</div>

<div class="soverlay oversearch" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="sclose closer"></div>
    <div class="search-form">
        <form method="get" class="searchform" action="<?php echo esc_url(home_url('/')) ?>">
            <input type="text" name="s" class="sinput" id="lsinput" placeholder="Какой материал вас интересует?" autocomplete="off">
        </form>
        <div class="autocomplete-wrapper">
            <div id="datafetch" class="results-container row"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="socup" tabindex="-1" role="dialog" aria-labelledby="socup" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<span id="socup-close" class="modal-close" data-dismiss="modal">&times;</span>
			<div class="modal-body">
                <div class="swidget">
                    <div class="swidget-bot">
                        <a class="stg" rel="noopener noreferrer nofollow" href="https://t.me/suleymaniya" target="_blank" title="Телеграм"><i class="icon-paper-plane-1"></i></a>
                        <a class="syt" rel="noopener noreferrer nofollow" href="https://www.youtube.com/channel/UCexDuRshhanLukE-NlQlcJQ" target="_blank" title="Youtube"><i class="icon-youtube-play"></i></a>
                    </div>
                </div>
			</div>
		</div>
	</div>
</div>

<?php wp_footer(); ?>

<?php $ip = $_SERVER['REMOTE_ADDR'];
    $country_code = tabgeo_country_v4($ip);
    if( $country_code == US || $country_code == DE ) { ?>
    
    <script type="text/javascript">
        //<![CDATA[
        var la=!1;
        window.addEventListener("scroll",function(){
            (0!=document.documentElement.scrollTop&&!1===la||0!=document.body.scrollTop&&!1===la)&&(!function(){
                var e=document.createElement("script");
                e.type="text/javascript",
                e.async=!0,
                e.src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-5540073383023855";
                var a=document.getElementsByTagName("script")[0];
                a.parentNode.insertBefore(e,a)
            }(),la=!0)
        },!0);
        //]]>
    </script>

<?php } ?>

</body>
</html>