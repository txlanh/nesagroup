<?php

extract( $atts );

// Enqueue Conditional Script
$this->scripts();

$classes = array( 
	'carousel-container',
	$fadesides,
	$el_class, 
	$this->get_id() 
);

$this->generate_css();

?>
<div id="<?php echo $this->get_id() ?>" class="<?php echo ld_helper()->sanitize_html_classes( $classes ); ?>">

	<div class="carousel-items row" <?php $this->get_options() ?>>
	<?php
		$this->columnize_content( $content );
		echo ld_helper()->do_the_content( $content );
	?>
	</div>

</div>