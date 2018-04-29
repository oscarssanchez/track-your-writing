<?php
/**
 * The authors writing data module
 *
 * @package @package TrackYourWriting
 */

namespace TrackYourWriting;
/**
 * Class TYW_User_Writing_Data
 *
 * @package TrackYourWriting
 */
class User_Writing_Data {
	/**
	 * Returns the current author total statistics
	 *
	 * @return array
	 */
	public function author_total_stats() {
		$args = array(
			'author'      => get_option( 'tyw_user_profile_id' ),
			'post_type'   => array( 'page', 'post' ),
			'post_status' => 'publish',
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
	 * Returns the current author monthly statistics.
	 *
	 * @return array
	 */
	public function author_month_stats() {
		$args = array(
			'author'      => get_option( 'tyw_user_profile_id' ),
			'post_type'   => array( 'page', 'post' ),
			'post_status' => 'publish',
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
	public static function month_chart_post_data() {
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

		$found_posts = array();
		$month_keys     = array( 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec' );
		$month_defaults = array_fill_keys( $month_keys, 0 );

		foreach ( $query->posts as $post ) {
			array_push( $found_posts, date( 'M', strtotime( $post->post_date ) ) );
		}
		$post_date_results = array_count_values( $found_posts );
		$post_count        = array_merge( $month_defaults, $post_date_results );
		$month_chart_data = array(
			array(
				'month_name' => 'Jan',
				'posts'      => $post_count['Jan'],
			),
			array(
				'month_name' => 'Feb',
				'posts'      => $post_count['Feb'],
			),
			array(
				'month_name' => 'Mar',
				'posts'      => $post_count['Mar'],
			),
			array(
				'month_name' => 'Apr',
				'posts'      => $post_count['Apr'],
			),
			array(
				'month_name' => 'May',
				'posts'      => $post_count['May'],
			),
			array(
				'month_name' => 'Jun',
				'posts'      => $post_count['Jun'],
			),
			array(
				'month_name' => 'Jul',
				'posts'      => $post_count['Jul'],
			),
			array(
				'month_name' => 'Aug',
				'posts'      => $post_count['Aug'],
			),
			array(
				'month_name' => 'Sep',
				'posts'      => $post_count['Sep'],
			),
			array(
				'month_name' => 'Oct',
				'posts'      => $post_count['Oct'],
			),
			array(
				'month_name' => 'Nov',
				'posts'      => $post_count['Nov'],
			),
			array(
				'month_name' => 'Dec',
				'posts'      => $post_count['Dec'],
			),
		);

		return json_encode( $month_chart_data );

	}

}
