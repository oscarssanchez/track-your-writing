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

	<div class="wrap postbox">
	<form method="post" action="<?php echo admin_url( 'admin-post.php' ); ?>" class="track-your-writing-form">
		<label for="rack-your-writing-update"><?php esc_html_e( 'Select a profile', 'track-your-writing' ); ?></label>
		<input type="hidden" name="action" value="track-your-writing-update">
		<?php
		wp_nonce_field( self::NONCE_ACTION, self::NONCE_NAME );
		$this->plugin->components->profile_manager->user_list();
		submit_button( __( 'Change user', 'track-your-writing' ) );
		?>
	</form>
	</div>
	<?php
	$profile_data  = $this->plugin->components->profile_manager->user_profile();
	$author_totals = $this->plugin->components->user_writing_data->author_total_stats();
	$author_month  = $this->plugin->components->user_writing_data->author_month_stats();
	?>
	<div class="tyw-settings-stats">
		<div class="postbox wrap tyw-writing-stats">
			<div class="tyw-welcome">
				<h2><?php echo ! empty( $profile_data['first_name'] ) ? esc_html__( 'Hi ', 'track-your-writing' ) . esc_html( $profile_data['first_name'] ) : esc_html( $profile_data['username'] ); ?>,</h2>
				<p><?php esc_html_e( 'This is your progress so far ;)', 'track-your-writing' ); ?></p>
			</div>
			<div class="tyw-stats-group">
				<div class="tyw-stats-item">
					<p class="tyw-item-label"><?php esc_html_e( ' Total Posts', 'track-your-writing' ); ?></p>
					<p class="tyw-item-data"><?php echo esc_html( $author_totals['total_posts'] ); ?></p>
				</div>
				<div class="tyw-stats-item">
					<p class="tyw-item-label"><?php esc_html_e( ' Posts this Month', 'track-your-writing' ); ?></p>
					<p class="tyw-item-data"><?php echo esc_html( $author_month['month_posts'] ); ?></p>
				</div>
				<div class="tyw-stats-item">
					<p class="tyw-item-label"><?php esc_html_e( ' Total Words', 'track-your-writing' ); ?></p>
					<p class="tyw-item-data"><?php echo esc_html( $author_totals['total_words'] ); ?></p>
				</div>
				<div class="tyw-stats-item">
					<p class="tyw-item-label"><?php esc_html_e( ' Words this Month', 'track-your-writing' ); ?></p>
					<p class="tyw-item-data"><?php echo esc_html( $author_month['month_words'] ); ?></p>
				</div>
				<div class="tyw-stats-item">
					<p class="tyw-item-label"><?php esc_html_e( ' Words per post on Average', 'track-your-writing' ); ?></p>
					<p class="tyw-item-data"><?php echo esc_html( $author_totals['avg_words'] ); ?></p>
				</div>
			</div>
			<div class="tyw-year">
				<h3><?php echo esc_html_e( 'The Year in Numbers', 'track-your-writing' ); ?></h3>
			</div>
			<div id="tyw-chart-section">
				<h1><?php esc_html_e( 'Posts per Month', 'track-your-writing' ); ?></h1>
				<svg id="tyw_month_chart"></svg>
			</div>
		</div>
	</div>

</div>