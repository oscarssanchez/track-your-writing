<?php
/**
 * The admin page class
 *
 * @package TrackYourWriting
 */

namespace TrackYourWriting;

/**
 * Class Admin
 *
 * @package TrackYourWriting
 */
class Admin {
	/**
	 * Track your writing slug.
	 *
	 * @var string
	 */
	public $_slug = 'track-your-writing';

	/**
	 * Track_Your_Writing_Admin initializer.
	 */
	public function init() {
		add_action( 'admin_menu', array( $this, 'admin_menus' ) );
		add_action( 'admin_head', array( $this, 'add_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'add_scripts' ) );
		add_action( 'init', array( $this, 'textdomain' ) );
	}

	/**
	 * Creates the admin menus for the plugin.
	 */
	public function admin_menus() {
		add_menu_page(
			__( 'Track your writing', 'track-your-writing' ),
			__( 'Track your writing', 'track-your-writing' ),
			'manage_options',
			'wp-trackyw',
			array( $this, 'render_single_mode' )
		);
	}

	/**
	 * Loads the plugin textdomain. Enables plugin translation.
	 */
	public function textdomain() {
		load_plugin_textdomain( $this->_slug );
	}

	/**
	 * Enqueues the CSS styles.
	 */
	public function add_styles() {
		wp_enqueue_style( 'track_your_writing_css', plugins_url( '../css/track-your-writing.css', __FILE__ ) );
	}

	/**
	 * Enqueues JS scripts
	 */
	public function add_scripts() {
		wp_enqueue_script( 'd3-scripts', plugins_url( '../js/d3/d3.min.js', __FILE__ ) );
		wp_enqueue_script( 'tyw-scripts', plugins_url( '../js/tyw-scripts.js', __FILE__ ), array( 'jquery' ), '', true );
		wp_localize_script( 'tyw-scripts', 'tyw_month_chart_data', User_Writing_Data::month_chart_post_data() );
	}

	/**
	 * Renders the whole admin page.
	 */
	public function render_single_mode() {
		$this->render_admin_header();
		$this->render_user_profile();
		$this->render_writing_stats();
		$this->render_set_goals();
	}

	/**
	 * Renders the admin header
	 */
	public function render_admin_header() {
		?>
		<div><h1><?php esc_html_e( 'Track Your Writing', 'track-your-writing' ); ?></h1>'
		<?php
	}

	/**
	 * Renders the user profile section.
	 */
	public function render_user_profile() {
		?>
		<div id="tyw-profile" class="postbox wrap">
			<p class="description"><?php esc_html_e( 'Select an author', 'track-your-writing' ); ?></p>
			<h2><?php esc_html_e( 'Select a profile', 'track-your-writing' ); ?></h2>
			<form method="post" action="">
				<?php
				wp_nonce_field( 'tyw_submit_user', 'tyw_submit_user_nonce' );
				Profile_Manager::user_list();
				submit_button( 'Update user' );
				$this->single_mode_process_form();
				?>
			</form>
			<?php
			$single_profile = new Profile_Manager();
			$profile_data   = $single_profile->user_profile();
			?>
			<div class="tyw-avatar">
				<img src="<?php echo esc_url( $profile_data['avatar'] ); ?>">
			</div>
			<div class="tyw-avatar-data">
				<div class="tyw-avatar-data">
					<p><span><?php esc_html_e( 'Name', 'track-your-writing' ); ?>:</span> <?php echo esc_html( $profile_data['name'] ); ?></p>
					<p><span><?php esc_html_e( 'Role', 'track-your-writing' ); ?>:</span> <?php echo esc_html( $profile_data['role'] ); ?></p>
					<p><span><?php esc_html_e( 'Email', 'track-your-writing' ); ?>:</span> <?php echo esc_html( $profile_data['email'] ); ?></p>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Render the current user statistics.
	 */
	public function render_writing_stats() {
		$single_profile_stats = new User_Writing_Data();
		$author_totals        = $single_profile_stats->author_total_stats();
		$author_month         = $single_profile_stats->author_month_stats();
		?>
		<div class="tyw-settings-left">
			<div class="postbox wrap writing-data">
				<h2><span class="dashicons dashicons-chart-bar"></span> <?php esc_html_e( 'Your Stats', 'track-your-writing' ); ?></h2>
				<p class="description"><?php esc_html_e( 'Display your current Statistics', 'track-your-writing' ); ?></p>
				<p><span class="tyw-totals"><?php echo esc_html( $author_totals['total_posts'] ); ?></span> <?php esc_html_e( 'Total Posts', 'track-your-writing' ); ?></p>
				<p><span class="tyw-totals"><?php echo esc_html( $author_month['month_posts'] ); ?></span><?php esc_html_e( 'Posts written this Month', 'track-your-writing' ); ?></p>
				<p><span class="tyw-totals"><?php echo esc_html( $author_totals['total_words'] ); ?></span><?php esc_html_e( 'Words written in Total', 'track-your-writing' ); ?></p>
				<p><span class="tyw-totals"><?php echo esc_html( $author_month['month_words'] ); ?></span><?php esc_html_e( 'Words written this Month', 'track-your-writing' ); ?></p>
				<p><span class="tyw-totals"><?php echo esc_html( $author_totals['avg_words'] ); ?></span><?php esc_html_e( 'Words per post on Average', 'track-your-writing' ); ?></p>
			</div>
		<?php
	}

	/**
	 * Render the current user goals.
	 */
	public function render_set_goals() {
		?>
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
		<?php
	}

	/**
	 * Process single mode form.
	 */
	public function single_mode_process_form() {
		if ( isset( $_POST['tyw_submit_user_nonce'] ) && wp_verify_nonce( $_POST['tyw_submit_user_nonce'], 'tyw_submit_user' ) && isset( $_POST['tyw_user_profile_id'] ) ) {
			update_option( 'tyw_user_profile_id', sanitize_text_field( wp_unslash( $_POST['tyw_user_profile_id'] ) ) );
		}
	}

}
