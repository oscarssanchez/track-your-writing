<?php
/**
 * The adming page class
 *
 * @package track-your-writing
 */

namespace TrackYourWriting;

/**
 * Class Track_Your_Writing_Admin
 *
 * @package TrackYourWriting
 */
class TYW_Admin {
	/**
	 * Track_Your_Writing_Admin constructor.
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'admin_menus' ) );
		add_action( 'admin_head', array( $this, 'add_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'add_scripts' ) );
	}

	/**
	 * Creates the admin menus for the plugin.
	 */
	public function admin_menus() {
		add_menu_page(
			'Track your writing',
			'Track your writing',
			'manage_options',
			'wp-trackyw',
			array( $this, 'render_single_mode' )
		);
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
		wp_enqueue_script( 'd3-scripts', 'https://d3js.org/d3.v5.min.js' );
		wp_enqueue_script( 'tyw-scripts', plugins_url( '../js/tyw-scripts.js', __FILE__ ), array( 'jquery' ), '', true );
		wp_localize_script( 'tyw-scripts', 'tyw_month_chart_data', TYW_User_Writing_Data::month_chart_post_data() );
	}

	/**
	 * Renders the whole admin page.
	 */
	public function render_single_mode() {
		self::render_admin_header();
		$this->render_user_profile();
		$this->render_writing_stats();
		$this->render_set_goals();
		self::render_admin_footer();
	}

	/**
	 * Renders the admin header
	 */
	public static function render_admin_header() {
		echo '<div><h1>Track Your Writing</h1>';
	}

	/**
	 * Renders the user profile section.
	 */
	public function render_user_profile() {
		?>
		<div id="tyw-profile" class="postbox wrap">
			<h2> Select a profile </h2>
			<p class="description">Select an author</p>
			<form method="post" action="">
				<?php
				wp_nonce_field( 'tyw_submit_user', 'tyw_submit_user_nonce' );
				TYW_profile_manager::user_list();
				submit_button( 'Update user' );
				$this->single_mode_process_form();
				?>
			</form>
			<?php
			$single_profile = new TYW_profile_manager();
			$profile_data   = $single_profile->user_profile();
			?>
			<div class="tyw-avatar">
				<img src="<?php echo $profile_data['avatar']; ?>">
			</div>
			<div class="tyw-avatar-data">
				<div class="tyw-avatar-data">
					<p><span>Name:</span> <?php echo $profile_data['name']; ?></p>
					<p><span>Role:</span> <?php echo $profile_data['role']; ?></p>
					<p><span>Email:</span> <?php echo $profile_data['email']; ?></p>
				</div>
			</div>
		</div>
		<?php
	}

	/**
	 * Render the current user statistics.
	 */
	public function render_writing_stats() {
		$single_profile_stats = new TYW_User_Writing_Data();
		$author_totals        = $single_profile_stats->author_total_stats();
		$author_month         = $single_profile_stats->author_month_stats();
		?>
		<div class="tyw-settings-left">
			<div class="postbox wrap writing-data">
				<h2><span class="dashicons dashicons-chart-bar"></span> Your Stats</h2>
				<p class="description">Display your current Statistics</p>
				<p><span class="tyw-totals"><?php echo $author_totals['total_posts']; ?></span> Total Posts</p>
				<p><span class="tyw-totals"><?php echo $author_month['month_posts']; ?></span> Posts written this Month</p>
				<p><span class="tyw-totals"><?php echo $author_totals['total_words']; ?></span> Words written in Total</p>
				<p><span class="tyw-totals"><?php echo $author_month['month_words']; ?></span> Words written this Month</p>
				<p><span class="tyw-totals"><?php echo $author_totals['avg_words']; ?></span> Words per post on Average</p>
			</div>
		<?php
	}

	/**
	 * Render the current user goals.
	 */
	public function render_set_goals() {
		?>
			<div class="postbox wrap writing-data ">
				<h1> Compare </h1>
				<p class="description">Compare your progress here</p>
				<div id="tyw_compare_section">
					<h1>Posts per Month</h1>
					<svg id="tyw_month_chart"></svg>
				</div>

			</div>
		</div>
		<?php
	}

	/**
	 * Renders the admin footer.
	 */
	public static function render_admin_footer() {
		echo '</div>';
	}

	/**
	 * Process single mode form.
	 */
	public function single_mode_process_form() {
		if ( isset( $_POST['tyw_submit_user_nonce'] ) ) {
			if ( wp_verify_nonce( $_POST['tyw_submit_user_nonce'], 'tyw_submit_user' ) ) {
				if ( isset( $_POST['tyw_user_profile_id'] ) ) {
					update_option( 'tyw_user_profile_id', $_POST['tyw_user_profile_id'] );
				}
			}
		}
	}

}
