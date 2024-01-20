<?php

// Enqueue Conditional Script

$style = $atts['style'];
$filter_id = $atts['filter_id'];
$filter_enable_counter = $atts['filter_enable_counter'];
$grid_columns = $atts['grid_columns'];
$ajax_trigger = $atts['ajax_trigger'];
$title_tag = $atts['tag'];
$tag_to_inherite = $atts['use_inheritance'] ? $atts['tag_to_inherite2'] : '';

// Locate the template and check if exists.
$located = locate_template( array(
	"templates/portfolio/tmpl-$style.php"
) );
if ( ! $located ) {
	return;
}

// Build Query and check for posts
$the_query = new WP_Query( $this->build_query() );
if( !$the_query->have_posts() ) {
	return;
}

$this->grid_id = $grid_id = uniqid( 'grid-');

// Enqueue Conditional Script
$this->scripts();

// The CSS
$this->generate_css();

$layout_mode = $atts['masonry_layout'] && $atts['masonry_layout'] === 'packery' ? 'packery' : 'fitRows';

$opt_counter = '';
if( 'yes' === $filter_enable_counter ) {
	$opt_counter = ', "filtersCounter":true';
}

//Container
echo '<div class="lqd-pf-grid ' . $this->get_id() . '">';

	if( 'masonry-creative' === $style ) {
		// Include filter
		if( 'yes' === $atts['show_filter'] ) {
			$filter_located = locate_template( 'templates/portfolio/partial-filters.php' );
			include $filter_located;
			printf( '<div id="%1$s" class="lqd-pf-row row d-flex flex-wrap %1$s" data-liquid-masonry="true" data-columns="%4$s" data-masonry-options=\'{ "filtersID": "#%2$s", "layoutMode": "masonry", "alignMid": true' . $opt_counter . ' }\' %3$s>', $this->grid_id, $filter_id, $this->get_options(), $grid_columns );
			echo '<div class="col-md-4 col-sm-6 col-xs-12 grid-stamp creative-masonry-grid-stamp"></div>';
		}
		else {
			printf( '<div id="%1$s" class="lqd-pf-row row d-flex flex-wrap %1$s" data-columns="%3$s" data-liquid-masonry="true" data-masonry-options=\'{ "layoutMode": "masonry", "alignMid": true }\' %2$s>', $this->grid_id, $this->get_options(), $grid_columns );
			echo '<div class="col-md-4 col-sm-6 col-xs-12 grid-stamp creative-masonry-grid-stamp"></div>';
		}
	}
	else {
		// Include filter
		if( 'yes' === $atts['show_filter'] ) {
			$filter_located = locate_template( 'templates/portfolio/partial-filters.php' );
			include $filter_located;
			printf( '<div id="%1$s" class="lqd-pf-row row d-flex flex-wrap %1$s" data-liquid-masonry="true" data-masonry-options=\'{ "filtersID": "#%2$s"' . $opt_counter . ' }\' %3$s>', $this->grid_id, $filter_id, $this->get_options() );
		}
		else {
			printf( '<div id="%1$s" class="lqd-pf-row row d-flex flex-wrap %1$s" data-liquid-masonry="true" data-masonry-options=\'{ "layoutMode": "' . $layout_mode . '"' . $opt_counter . ' }\' %2$s>', $this->grid_id, $this->get_options() );
		}
	}



	// Build Query
	$GLOBALS['wp_query'] = $the_query;
	$before = $after = '';

	$this->add_excerpt_hooks();

	while( have_posts() ): the_post();

		$post_classes = array( 'lqd-pf-item', 'pos-rel', $this->get_item_classes() );
		$post_classes = join( ' ', get_post_class( $post_classes, get_the_ID() ) );

		$attributes = array(
			'id'    => 'post-' . get_the_ID(),
			'class' => $post_classes
		);

		echo $before;

			include $located;

		echo $after;

	endwhile;

	$this->remove_excerpt_hooks();

	echo '</div><!-- /.liquid-portfolio-list-row -->';

	// Pagination
	if( 'pagination' === $atts['pagination'] ) {

		// Set up paginated links.
        $links = paginate_links( array(
			'type' => 'array',
			'prev_next' => true,
			'prev_text' => '<span aria-hidden="true">' . __( '<i class="fa fa-angle-left"></i>', 'landinghub-core' ) . '</span>',
			'next_text' => '<span aria-hidden="true">' . __( '<i class="fa fa-angle-right"></i>', 'landinghub-core' ) . '</span>'
		));
		if( !empty( $links ) ) {
			printf( '<div class="page-nav"><nav aria-label="' . esc_attr__( 'Page navigation', 'landinghub-core' ) . '"><ul class="pagination"><li>%s</li></ul></nav></div>', join( "</li>\n\t<li>", $links ) );
		}
	}

	if( in_array( $atts['pagination'], array( 'ajax' ) ) && $url = get_next_posts_page_link( $GLOBALS['wp_query']->max_num_pages ) ) {
		$hash = array(
			'ajax' => 'btn btn-md ajax-load-more',
		);

		$attributes = array(
			'href' => add_query_arg( 'ajaxify', '1', $url ),
			'rel' => 'nofollow',
			'data-ajaxify' => true,
			'data-ajaxify-options' => json_encode( array(
				'wrapper' => '.lqd-pf-grid .lqd-pf-row',
				'items'   => '> .masonry-item',
				'trigger' => $ajax_trigger,
			) )
		);

		echo '<div class="liquid-pf-nav ld-pf-nav-ajax"><div class="page-nav text-center"><nav aria-label="' . esc_attr__( 'Page navigation', 'landinghub-core' ) . '">';
		switch( $atts['pagination'] ) {

			case 'ajax':
				$ajax_text = ! empty( $atts['ajax_text'] ) ? esc_html( $atts['ajax_text'] ) : esc_html__( 'Load more', 'landinghub-core' );
				$attributes['class'] = 'ld-ajax-loadmore';
				printf( '<a%2$s><span><span class="static">%1$s</span><span class="loading"><span class="dots"><span></span><span></span><span></span></span><span class="text-uppercase lts-sp-1">' . esc_html__( 'Loading', 'landinghub-core' ) . '</span></span><span class="all-loaded">' . esc_html__( 'All items loaded', 'landinghub-core' ) . ' <i class="lqd-icn-ess icon-ion-ios-checkmark"></i></span></span></a>', $ajax_text, ld_helper()->html_attributes( $attributes ), $url );
				break;
		}

		echo '</nav></div></div>';
	}

	wp_reset_query();

echo '</div><!-- /.liquid-portfolio-list -->';