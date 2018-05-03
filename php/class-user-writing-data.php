<?php
/**
 * The authors writing data module
 *
 * @package TrackYourWriting
 */

namespace TrackYourWriting;

/**
 * Class User_Writing_Data
 *
 * @package TrackYourWriting
 */
class User_Writing_Data {
	/**
	 * Returns the current author total statistics.
	 *
	 * @return array
	 */
	public function author_total_stats() {
		$args = array(
			'author'      => get_option( 'tyw_user_profile_id' ),
			'post_type'   => array( 'page', 'post' ),
			'post_status' => 'publish',
			'posts_per_page' => 500,
		);

		$query = new \WP_Query( $args );
		$total_words = 0;
		foreach ( $query->posts as $post ) {
			$content = str_word_count( $post->post_content );
			$total_words += $content;
		}
		if ( empty( $total_words ) ) {
			$avg = 0;
		} else {
			$avg = round( $total_words / $query->found_posts );
		}

		$total_posts = $query->found_posts;

		return array(
			'total_posts' => $total_posts,
			'total_words' => $total_words,
			'avg_words'   => $avg,
		);
	}

	/**
	 * Returns the current author's monthly statistics.
	 *
	 * @return array
	 */
	public function author_month_stats() {
		$args = array(
			'author'      => get_option( 'tyw_user_profile_id' ),
			'post_type'   => array( 'page', 'post' ),
			'post_status' => 'publish',
			'posts_per_page' => 100,
			'date_query'  => array(
				array(
					'after' => '30 days ago',
				),
			),
		);
		$query = new \WP_Query( $args );
		$monthly_words = 0;
		foreach ( $query->posts as $post ) {
			$content = str_word_count( $post->post_content );
			$monthly_words += $content;
		}
		$monthly_posts = $query->found_posts;

		return array(
			'month_posts' => $monthly_posts,
			'month_words' => $monthly_words,
		);
	}

	/**
	 * Fetches and organizes the data for Chart displaying.
	 *
	 * @return mixed|null|
	 */
	public function month_chart_post_data() {
		$args = array(
			'author'         => get_option( 'tyw_user_profile_id' ),
			'post_type'      => array( 'page', 'post' ),
			'post_status'    => 'publish',
			'posts_per_page' => 100,
			'date_query'  => array(
				array(
					'year' => date( 'Y' ),
				),
			),
		);
		$query = new \WP_Query( $args );
		if ( null == $query->found_posts ) {
			return null;
		}

		$found_posts    = array();
		$month_keys     = array( 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec' );
		$month_defaults = array_fill_keys( $month_keys, 0 );

		foreach ( $query->posts as $post ) {
			array_push( $found_posts, date( 'M', strtotime( $post->post_date ) ) );
		}
		$post_date_results = array_count_values( $found_posts );
		$post_count        = array_merge( $month_defaults, $post_date_results );
		$month_chart_data  = array();

		foreach ( $post_count as $item ) {
			array_push( $month_chart_data, array( 'posts' => $item ) );
		}

		return json_encode( $month_chart_data );

	}

}
