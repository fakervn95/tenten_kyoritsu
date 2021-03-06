<?php
add_action('admin_menu', 'ch_essentials_admin');
function ch_essentials_admin() {
	register_setting('zang-settings-header', 'header_fb');
	register_setting('zang-settings-header', 'header_phone');
	register_setting('zang-settings-header', 'header_insta');
	register_setting('zang-settings-footer', 'footer_fb');
	register_setting('zang-settings-footer', 'footer_zalo');
	register_setting('zang-settings-footer', 'footer_insta');
	/* Base Menu */
	add_menu_page('Zang Theme Option','ZQ Framework','manage_options','template_admin_zang','zang_theme_create_page',get_template_directory_uri() . '/images/setting_icon.png',110);
}
add_action('admin_init', 'zang_custom_settings');
function zang_custom_settings() { 

	/* Header Options Section */
	add_settings_section('zang-header-options', 'Chỉnh sửa social header','zang_header_options_callback','zang-settings-header' );
	add_settings_field('facebook','Facebook Header', 'zang_header_fb','zang-settings-header', 'zang-header-options');
	add_settings_field('phone_hd','Phone Header', 'zang_header_phone','zang-settings-header', 'zang-header-options');
	add_settings_field('insta','Instagram Header', 'zang_header_insta','zang-settings-header', 'zang-header-options');

	/* Social Options Section */
	add_settings_section('zang-social-options','Chỉnh sửa social footer','zang_social_options_callback','zang-settings-footer' );
	add_settings_field('facebook','Facebook Footer', 'zang_footer_fb','zang-settings-footer', 'zang-social-options');
	add_settings_field('zalo','Zalo Footer', 'zang_footer_zalo','zang-settings-footer', 'zang-social-options');
	add_settings_field('insta','Instagram Footer', 'zang_footer_insta','zang-settings-footer', 'zang-social-options');

}

function zang_header_options_callback(){
	echo '';
}

function zang_social_options_callback(){
	echo '';
}


function zang_header_fb(){
	$header_fb = esc_attr(get_option('header_fb'));
	echo '<input type="text" class="iptext_adm" name="header_fb" value="'.$header_fb.'">';
}
function zang_header_phone(){
	$header_phone = esc_attr(get_option('header_phone'));
	echo '<input type="text" class="iptext_adm" name="header_phone" value="'.$header_phone.'" >';
}
function zang_header_insta(){
	$header_insta = esc_attr(get_option('header_insta'));
	echo '<input type="text" class="iptext_adm" name="header_insta" value="'.$header_insta.'"  ';
}
function zang_footer_fb(){
	$footer_fb = esc_attr(get_option('footer_fb'));
	echo '<input type="text" class="iptext_adm" name="footer_fb" value="'.$footer_fb.'" placeholder="" ';
}
function zang_footer_zalo(){
	$footer_zalo = esc_attr(get_option('footer_zalo'));
	echo '<input type="text" class="iptext_adm" name="footer_zalo" value="'.$footer_zalo.'" placeholder="" ';
}
function zang_footer_insta(){
	$footer_insta = esc_attr(get_option('footer_insta'));
	echo '<input type="text" class="iptext_adm" name="footer_insta" value="'.$footer_insta.'" placeholder="" ';
}

function myshortcode(){
	ob_start();
	if(get_option('footer_fb') || get_option('footer_twitter') || get_option('footer_zalo') || get_option('footer_insta') ){
		?>
		<ul class="social_ft">
			<?php if(get_option('footer_fb')){ ?>
				<li class="fb_ft"><a href="<?php echo get_option('footer_fb'); ?>" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
			<?php }?>
			<?php if(get_option('footer_twitter')){ ?>
				<li class="twitter"><a href="<?php echo get_option('footer_twitter'); ?>" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></i></a></li>
			<?php }?>
			<?php if(get_option('footer_zalo')){ ?>
				<li class="ggplus"><a href="<?php echo get_option('footer_zalo'); ?>" target="_blank"><i class="fa fa-google" aria-hidden="true"></i></a></li>
			<?php }?>
			<?php if(get_option('footer_insta')){ ?>
				<li class="instagram"><a href="<?php echo get_option('footer_insta'); ?>" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
			<?php }?>
		</ul>	
		<?php
	}
	return ob_get_clean();
}
add_shortcode('social_ft','myshortcode');

function shortcode_news(){
	ob_start();
	?>
	<?php 
	$arg_cmt_post_q = array(
		'posts_per_page' => 3,
		'orderby' => 'post_date',
		'order' => 'DESC',
		'post_type' => 'post',
		'post_status' => 'publish',
		'cat' => array(2)
	);
	$cmt_post_q = new WP_Query();
	$cmt_post_q->query($arg_cmt_post_q);
	?>
	<?php if(have_posts()) : ?>
		<ul>
			<?php
			while ($cmt_post_q->have_posts()) : $cmt_post_q->the_post(); ?>
				<li class="col-sm-4">
					<div class="post_cmt_wrapper">
						<div class="wrap_thumb">
							<?php  $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );  ?>
							<figure class="thumbnail" style="background:url('<?php echo $image[0]; ?>');"> 
								<a href="<?php the_permalink();?>"></a>
							</figure>	
						</div>
						<h3><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a> </h3>
						<div class="excerpt">
							<p><?php echo excerpt(50); ?></p>
						</div>
						<div class="read_more">
							<a href="<?php the_permalink(); ?>"><?php if(get_locale() == 'en_US'){echo 'Read more >';} else { echo 'Xem thêm';}  ?></a>
						</div>
					</div>
				</li>
			<?php endwhile; ?>
		<?php endif; ?> 
	</ul>
	<?php
	return ob_get_clean();
}

add_shortcode('tg_shortcode_new','shortcode_news');

function shortcode_featured(){
	ob_start();
	?>
	<?php    
                        $parent  = get_categories(array('parent'=>7));  // parent=>0 loop all
                        ?>
                        <div class="wrap_featured_work">
                        	<?php
                        	foreach ( $parent as $category ) {

                        		$args = array(
                        			'cat' => $category->term_id,
                        			'post_type' => 'post',
                        			'posts_per_page' => '5',
                        		//'category__not_in' => array( 38 )
                        		);
                        		$query = new WP_Query( $args );

                        		if ( $query->have_posts() ) { ?>
                        			<div class="listing">
                        				<?php  $catgory_id = get_cat_ID($category->name);
                        				$category_link = get_category_link( $catgory_id );
                        				$image_id = get_term_meta ( $category->term_id, 'category-image-id', true );
                        				$src_image = wp_get_attachment_image_src( $image_id , 'full');
                                    //echo $src_image[0];
                        				?>
                        				<div class="product_inner">
                        					<div class="wrap_thumb">
                        						<figure class="thumbnail" style="background:url('<?php echo $src_image[0];?>') "><a href="<?php echo get_page_link(23); ?>"></a></figure>	
                        					</div>
                        					<h2><a href="<?php echo get_page_link(23); ?>"><?php echo $category->name; ?></a></h2>
                        				</div>
                        			</div>
                     <?php } // end if
                        // Use reset to restore original query.
                     wp_reset_postdata();
                 }
                 ?>
             </div>
             <?php
             return ob_get_clean();
         }

         add_shortcode('tg_shortcode_featured','shortcode_featured');

/* Display Page
-----------------------------------------------------------------*/
function zang_theme_create_page() {
	?>
	<div class="wrap">  
		<?php settings_errors(); ?>  

		<?php  
		$active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'header_page_options';  
		?>  

		<ul class="nav-tab-wrapper"> 
			<li><a href="?page=template_admin_zang&tab=header_page_options" class="nav-tab <?php echo $active_tab == 'header_page_options' ? 'nav-tab-active' : ''; ?>">Social Header</a> </li>
			<li><a href="?page=template_admin_zang&tab=footer_page_options" class="nav-tab <?php echo $active_tab == 'footer_page_options' ? 'nav-tab-active' : ''; ?>">Social Footer</a></li>
		</ul>  

		<form method="post" action="options.php">  
			<?php 
			if( $active_tab == 'header_page_options' ) {  
				settings_fields( 'zang-settings-header' );
				do_settings_sections( 'zang-settings-header' ); 
			} else if( $active_tab == 'footer_page_options' ) {
				settings_fields( 'zang-settings-footer' );
				do_settings_sections( 'zang-settings-footer' ); 
			}
			?>             
			<?php submit_button(); ?>  
		</form> 

	</div> 
	<?php
}

