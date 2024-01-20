<?php

// Enqueue Conditional Script
$this->scripts();

extract( $atts );

$classes = array( 
	'lqd-modal',
	'lity-hide',
	$el_class
);

?>
<!-- Modal Body -->
<div id="<?php echo $this->get_id(); ?>" class="<?php echo ld_helper()->sanitize_html_classes( $classes ); ?>" data-modal-type="<?php echo $this->get_modal_type(); ?>">

	<div class="lqd-modal-inner">
		<div class="lqd-modal-head">
			<h2><?php $this->get_title(); ?></h2>
		</div><!-- /.lqd-modal-head -->
		<div class="lqd-modal-content">

			<?php echo ld_helper()->do_the_content( $content, false ); ?>

		</div><!-- /.lqd-modal-content -->
		<div class="lqd-modal-foot"></div><!-- /.lqd-modal-foot -->

	</div><!-- /.lqd-modal-inner -->
</div><!-- /#modal-box.lqd-modal -->