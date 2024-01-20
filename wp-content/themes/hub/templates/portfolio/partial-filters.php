<?php

extract( $atts );

if( function_exists( 'ld_helper' ) ) {
	$filter_cats = ld_helper()->terms_are_ids_or_slugs( $filter_cats, 'liquid-portfolio-category' );
}

$terms = get_terms( array(
	'taxonomy'   => 'liquid-portfolio-category',
	'hide_empty' => false,
	'include'    => $filter_cats
) );

if( empty( $terms ) ) {
	return;
}

$wrapper_align = $filter_align;
if( !empty( $show_button ) ) { 
	$wrapper_align = 'justify-content-between';
}

$filter_wrapper = array(
	'liquid-filter-items',
	'align-items-center',
	$wrapper_align,
);

$filter_classnames = array(
	'filter-list',
	'filter-list-inline',
	$filter_color,
	$filter_size,
	$filter_decoration === 'filters-underline' || $filter_decoration === 'filters-underline' ? 'filter-list-decorated' : '',
	$filter_decoration,
	$filter_transformation,
	$filter_weight,
	'd-flex',
	'align-items-center'
);

$filter_title_classnames = array(
	'liquid-filter-items-label',
	$tag_to_inherite,
	$filter_title_size,
	$filter_title_weight,
	$filter_title_transformation
);

?>			
<div class="<?php echo join( ' ', $filter_wrapper ); ?>">	
	<div class="liquid-filter-items-inner flex-grow-1">
		
		<?php if( !empty( $filter_title ) ) { ?>
			<span class="<?php echo join( ' ', $filter_title_classnames ); ?>"><?php echo wp_kses_post( do_shortcode( $filter_title ) );  ?></span>
		<?php } ?>

		<ul class="<?php echo join( ' ', $filter_classnames ); ?> hidden-xs hidden-sm" id="<?php echo esc_attr( $filter_id ); ?>">
			<li class="active" data-filter="*"><span><?php echo esc_html( $filter_lbl_all ) ?></span></li>
			<?php foreach( $terms as $term ) {
				printf( '<li data-filter=".%s"><span>%s</span></li>', $term->slug, $term->name );
			} ?>
		</ul>

		<div class="lqd-filter-dropdown visible-xs visible-sm" data-form-options='{ "dropdownAppendTo": "self" }'>
			<select name="lqd-filter-dropdown-<?php echo esc_attr( $filter_id ); ?>" id="lqd-filter-dropdown-<?php echo esc_attr( $filter_id ); ?>">
				<option selected data-filter="*" value="*"><?php echo esc_html( $filter_lbl_all ) ?></option>
				<?php foreach( $terms as $term ) {
					printf( '<option data-filter=".%s" value=".%s">%s</option>', $term->slug, $term->slug, $term->name  );
				} ?>
			</select>
		</div>
			
		<?php $this->get_button()  ?>					
			
	</div>
</div>