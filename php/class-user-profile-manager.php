<?php

namespace TrackYourWriting;
/**
 * Class TYW_profile_manager
 *
 * @package TrackYourWriting
 */
class TYW_profile_manager {
	/**
	 * Gets the site user list with posting capabilities.
	 *
	 * @return array
	 */
	public static function get_users() {
		$users = get_users(
			array(
				'role__not_in' => array( 'contributor', 'subscriber' ),
				'fields'       => array( 'display_name', 'ID' ),
			)
		);
		return $users;
	}

	/**
	 * Renders a list of users with posting capabilities.
	 */
	public static function user_list() {
		echo '<select id="select_user_profile" name="tyw_user_profile_id">';
		foreach ( self::get_users() as $user ) {
			echo '<option value="' . $user->ID . '">' . $user->display_name . '</option>';
		}
		echo '</select>';
	}

	/**
	 * Gets the user profile
	 *
	 * @return array
	 */
	public function user_profile() {
		$user_data = get_userdata( get_option( 'tyw_user_profile_id' ) );

		$user_profile_data = array(
			'avatar' => get_avatar_url( get_option( 'tyw_user_profile_id' ) ),
			'name'   => $user_data->first_name . ' ' . $user_data->last_name,
			'role'   => implode( $user_data->roles ),
			'email'  => $user_data->user_email,
		);

		return $user_profile_data;
	}
}