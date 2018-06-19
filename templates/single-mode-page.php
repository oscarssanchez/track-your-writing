<?php
/**
 * The admin page template.
 *
 * @package track-your-writing
 */

namespace TrackYourWriting;

defined( 'WPINC' ) or die;

// Check referrer.
if ( ! ( $this instanceof Admin ) ) {
	return;
}
?>
<div class="wrap">
	<h2><?php echo esc_html( $GLOBALS['title'] ); ?></h2>
	<div id="tyw-profile" class="postbox wrap">
		<h3><?php esc_html_e( 'Select a profile', 'track-your-writing' ); ?></h3>
		<form method="post" action="<?php echo admin_url( 'admin-post.php' ); ?>" class="track-your-writing-form">
			<input type="hidden" name="action" value="track-your-writing-update">
			<?php
			wp_nonce_field( self::NONCE_ACTION, self::NONCE_NAME );
			$this->plugin->components->profile_manager->user_list();
			submit_button( __( 'Update user', 'track-your-writing' ) );
			?>
		</form>
		<?php $profile_data = $this->plugin->components->profile_manager->user_profile(); ?>
		<div class="tyw-avatar">
			<img src="<?php echo esc_url( $profile_data['avatar'] ); ?>">
		</div>
		<div class="tyw-avatar-data">
			<div class="tyw-avatar-data">
				<p><span><?php esc_html_e( 'Username', 'track-your-writing' ); ?>:</span> <?php echo esc_html( $profile_data['username'] ); ?></p>
				<p><span><?php esc_html_e( 'Role', 'track-your-writing' ); ?>:</span> <?php echo esc_html( $profile_data['role'] ); ?></p>
				<p><span><?php esc_html_e( 'Email', 'track-your-writing' ); ?>:</span> <?php echo esc_html( $profile_data['email'] ); ?></p>
			</div>
		</div>
	</div>
	<?php
	$author_totals = $this->plugin->components->user_writing_data->author_total_stats();
	$author_month  = $this->plugin->components->user_writing_data->author_month_stats();
	?>
	<div class="tyw-settings-left">
		<div class="postbox wrap writing-data">
			<h2><span class="dashicons dashicons-chart-bar"></span> <?php esc_html_e( 'Your Stats', 'track-your-writing' ); ?></h2>
			<p class="description"><?php esc_html_e( 'Display your current Statistics', 'track-your-writing' ); ?></p>
			<p><span class="tyw-totals"><?php echo esc_html( $author_totals['total_posts'] ); ?></span> <?php esc_html_e( ' Total Posts', 'track-your-writing' ); ?></p>
			<p><span class="tyw-totals"><?php echo esc_html( $author_month['month_posts'] ); ?></span><?php esc_html_e( ' Posts written this Month', 'track-your-writing' ); ?></p>
			<p><span class="tyw-totals"><?php echo esc_html( $author_totals['total_words'] ); ?></span><?php esc_html_e( ' Words written in Total', 'track-your-writing' ); ?></p>
			<p><span class="tyw-totals"><?php echo esc_html( $author_month['month_words'] ); ?></span><?php esc_html_e( ' Words written this Month', 'track-your-writing' ); ?></p>
			<p><span class="tyw-totals"><?php echo esc_html( $author_totals['avg_words'] ); ?></span><?php esc_html_e( ' Words per post on Average', 'track-your-writing' ); ?></p>
		</div>
		<div class="postbox wrap writing-data ">
			<h1><?php esc_html_e( 'Compare', 'track-your-writing' ); ?> </h1>
			<p class="description"><?php esc_html_e( 'Compare your progress here', 'track-your-writing' ); ?></p>
			<div id="tyw_compare_section">
				<h1><?php esc_html_e( 'Posts per Month', 'track-your-writing' ); ?></h1>
				<svg id="tyw_month_chart"></svg>
			</div>
		</div>
	</div>
</div>
