<?php
/**
 * The adming page class}
 *
 * @package track-your-writing
 */

namespace TrackYourWriting;

/**
 * Class Track_Your_Writing_Admin
 *
 * @package TrackYourWriting
 */
class Track_Your_Writing_Admin {
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
			array( $this, 'render_admin_page' )
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
		wp_enqueue_script( 'tyw-scripts', plugins_url( '../js/tyw-scripts.js', __FILE__ ), array( 'jquery' ), true );
	}
	/**
	 * Renders the whole admin page.
	 */
	public function render_admin_page() {
		self::render_admin_header();
		$this->render_user_profile();
		$this->render_writing_stats();
		$this->render_set_goals();
		$this->render_goal_setting();
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
		$users = $this->get_user_list();
		?>
		<div id="tyw-profile" class="postbox wrap">
			<h2>Select a profile </h2>
			<form>
				<select id="select_user_profile" name="tyw_user_profile"">
				<?php
				foreach ( $users as $user ) {
					echo '<option value="' . $user->ID . '">' . $user->display_name . '</option>';
				}
				?>
				</select>
			</form>
			<?php
			/** RENDER THE PROFILE DATA **/
			echo $this->profile_data( 3 );
			?>
		</div>
		<?php
	}
	/**
	 * Profile data module
	 *
	 * @param int $id The ID of the user.
	 *
	 * @return string
	 */
	public function profile_data( $id ) {
		$user_info = get_userdata( $id );
		$html      =
		'<div class="tyw-avatar">
				<img src="' . get_avatar_url( $id ) . '">
			</div>
			<div class="tyw-avatar-data">
				<p><span>Name:</span> ' . $user_info->first_name . ' ' . $user_info->last_name . '</p>
				<p><span>Role:</span> ' . implode( $user_info->roles ) . '</p>
				<p><span>Email:</span> ' . $user_info->user_email . '</p>
			</div>';
		return $html;
	}
	/**
	 * Render the current user statistics.
	 */
	public function render_writing_stats() {
		?>
		<div class="tyw-settings-left">
			<div class="postbox wrap writing-data">
				<h2><span class="dashicons dashicons-chart-bar"></span> Your Stats</h2>
				<p class="description">Display your current progress</p>
				<p><span>32</span> Posts written this month</p>
				<p><span>12502</span> Words written this month</p>
			</div>
		<?php
	}
	/**
	 * Render the current user goals.
	 */
	public function render_set_goals() {
		?>
			<div class="postbox wrap set-goals">
				<h1><span class="dashicons dashicons-flag"></span> Goal Setting</h1>
				<p class="description">Set your goals here</p>
				<form>
					<label for="tyw-set-post">Set post number</label>
					<input type="text">
					<label for="tyw-set-time">Set time</label>
					<select>
						<option value="value1">Monthly</option>
						<option value="value1">Weekly</option>
					</select>
					<?php submit_button(); ?>
				</form>
			</div>
		</div>
		<?php
	}
	/**
	 * Render the goal setting section.
	 */
	public function render_goal_setting() {
		?>
		<div class="tyw-sidebar-left">
			<div class="postbox wrap writing-goals">
				<h1><span class="dashicons dashicons-awards"></span> Your Goals</h1>
				<p>32/100 posts</p>
				<p>12502/400,000 words</p>
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
	 * Gets the site user list with posting capabilities.
	 *
	 * @return array
	 */
	public function get_user_list() {
		$users = get_users(
			array(
				'role__not_in' => array( 'contributor', 'subscriber' ),
				'fields'       => array( 'display_name', 'ID' ),
			)
		);
		return $users;
	}
}
