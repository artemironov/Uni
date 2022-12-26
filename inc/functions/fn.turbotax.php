<?php

add_action('init', 'customRSS');
function customRSS(){
    add_feed('turbotax', 'turbotaxRSS');
}


function turbotaxRSS() {
    $postCount = 5;
    $posts = query_posts('showposts=' . $postCount);
    header('Content-Type: '.feed_content_type('rss2').'; charset='.get_option('blog_charset'), true);
    echo '<?xml version="1.0" encoding="'.get_option('blog_charset').'"?'.'>'.PHP_EOL; ?>
    <rss xmlns:yandex="http://news.yandex.ru" xmlns:media="http://search.yahoo.com/mrss/" xmlns:turbo="http://turbo.yandex.ru" version="2.0">
        <channel>
            <title><?php bloginfo_rss('name'); ?> - <?php bloginfo_rss('description'); ?></title>
            <link><?php bloginfo_rss('url') ?></link>
            <description>Турецкие актеры, персонажи турецких сериалов</description>
            <language>ru</language>
            
            <?php $actors = get_terms([
	               'taxonomy' => 'actors',
	               'hide_empty' => false,
                ]);
                if( $actors ) :
                    foreach($actors as $actor) :       
            ?>
              
            
               
                <item turbo="true">
                    <turbo:extendedHtml>true</turbo:extendedHtml>
                    <title><?php echo $actor->name; ?></title>
                    <link><?php echo get_term_link($actor); ?></link>
                    <turbo:topic><?php echo $actor->name; ?></turbo:topic>
                    <turbo:source><?php echo get_term_link($actor); ?></turbo:source>                   
                    <turbo:content>
                        <![CDATA[
                            <?php echo $actor->description;
                                $main_txt = get_field('main-txt', $actor);
                                echo $main_txt;
                            ?>
                        ]]>
                    </turbo:content>

                </item>
                
            <?php endforeach; endif; ?>
            
            
            
            <?php $characters = get_terms([
	               'taxonomy' => 'characters',
	               'hide_empty' => false,
                ]);
                if( $characters ) :
                    foreach($characters as $character) :       
            ?>
              
            
               
                <item turbo="true">
                    <turbo:extendedHtml>true</turbo:extendedHtml>
                    <title><?php echo $character->name; ?></title>
                    <link><?php echo get_term_link($character); ?></link>
                    <turbo:topic><?php echo $character->name; ?></turbo:topic>
                    <turbo:source><?php echo get_term_link($character); ?></turbo:source>                   
                    <turbo:content>
                        <![CDATA[
                            <?php echo $character->description;
                                $main_txt_char = get_field('main-txt', $character);
                                echo $main_txt_char;
                            ?>
                        ]]>
                    </turbo:content>

                </item>
                
            <?php endforeach; endif; ?>
        </channel>
    </rss>
<?php }

