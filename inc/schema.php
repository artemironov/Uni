<?php add_action("wp_head","insert_json_ld");

function insert_json_ld() {
	// Single
	
	if (is_singular('post')) {
		if (have_posts()) : while (have_posts()) : the_post();
			$url = wp_get_canonical_url();
			$headline = get_the_title();
			if( get_the_post_thumbnail(get_the_ID()) != '' ) {
				$image = get_the_post_thumbnail_url(get_the_ID(), "full");
			}
			$dataPublished         = get_the_time("c");
			$dateModified          = get_post_modified_time('Y-m-d');
        
			$preanons              = get_field('anons');
            $deltags               = strip_tags($preanons);
            $delsymb               = array("\r\n", "\n", "\r", "&#8211;");
            $anons               = str_replace($delsymb, '', $deltags );
			//$articleBody           = get_content_by_id(get_the_ID());
        
			$authorName            = get_the_author();
			$publisherName         = get_bloginfo('name');
			//$commentCount          = get_comments_number();
            $ratingValue           = get_field('rating-value');
            $ratingCount           = get_field('rating-count');
            $genres                = get_the_category();
            $authors               = get_the_terms(get_the_ID(), 'developer' );
        
            $rows                  = get_field('tech-loop');
            $first_row             = $rows[0];
            $processorRequirements = $first_row['tech-cpu'];
            $memoryRequirements    = $first_row['tech-ozu'];
            $storageRequirements   = $first_row['tech-disk'];
        
            //print_r($anons);
?>
		
			<script type="application/ld+json">
				{
					"@context": "http://schema.org",
					"@type": "VideoGame",
                    "applicationCategory": "Game",
                    "name": "<?php echo $headline; ?>",
                    "url": "<?php echo $url; ?>",
                    "image": "<?php echo $image; ?>",
                    "description": "<?php echo $anons; ?>",
                    "datePublished": "<?php echo $dataPublished; ?>",
					"dateModified": "<?php echo $dateModified; ?>",
                    "aggregateRating": {
                        "@type":"AggregateRating",
                        "worstRating": "1",
                        "ratingValue": <?php echo $ratingValue; ?>,
                        "bestRating": "5",                        
                        "ratingCount": <?php echo $ratingCount; ?>
                    },
                    "genre": "<?php echo esc_html($genres[0]->name); ?>",
                    "operatingSystem": "Microsoft Windows X",
                    "gamePlatform": "Microsoft Windows X",
                    "processorRequirements": "<?php echo esc_html($processorRequirements); ?>",
                    "memoryRequirements": "<?php echo esc_html($memoryRequirements); ?> Gb",
                    "storageRequirements": "<?php echo esc_html($storageRequirements); ?> Gb",
                    "author": {
                        "@type": "Organization",
                        "name": "<?php echo esc_html( $authors[0]->name ) ?>"
                    },
                    "publisher": {
                        "@type": "Organization",
                        "name": "<?php echo esc_html( $authors[0]->name ) ?>"
                    }
				}
			</script>
			
		<?php endwhile; endif; rewind_posts(); ?>
	<?php }
} ?>