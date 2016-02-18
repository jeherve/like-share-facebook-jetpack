<?php

if ( class_exists( 'Share_Twitter' ) && ! class_exists( 'Fb_Like_Share' ) ) :

// Build button
class Fb_Like_Share extends Share_Twitter {
	var $shortname = 'fb-like-share';
	public function __construct( $id, array $settings ) {
		parent::__construct( $id, $settings );
		$this->smart = 'official' == $this->button_style;
		$this->icon = 'icon' == $this->button_style;
		$this->button_style = 'icon-text';
	}

	public function get_name() {
		return __( 'Facebook Like', 'jeherve_fb_like_jetpack' );
	}

	public function display_footer() { ?>
		<script>(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.4&appId=249643311490";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));</script>
	<?php }

	public function get_display( $post ) {
		$display = '';

		$display .= sprintf(
			'<div id="fb-root"></div><div class="fb-like" data-href="%s" data-layout="button_count" data-action="like" data-show-faces="true"></div>',
			esc_url( get_permalink( $post->ID ) )
		);

		return $display;
	}

}

endif; // class_exists
