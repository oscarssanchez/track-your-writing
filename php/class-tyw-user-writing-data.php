<?php
/**
 * The authors writing data module
 *
 * @package @package track-your-writing
 */

namespace TrackYourWriting;

use SebastianBergmann\Comparator\DateTimeComparator;

/**
 * Class TYW_User_Writing_Data
 *
 * @package TrackYourWriting
 */
class TYW_User_Writing_Data {

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

		$totals = array(
			'total_posts' => $total_posts,
			'total_words' => $total_words,
			'avg_words'   => $avg,
		);

		return $totals;
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

		$totals = array(
			'month_posts' => $monthly_posts,
			'month_words' => $monthly_words,
		);

		return $totals;
	}

	/**
	 * Organizes the data for Chart displaying.
	 *
	 * @return mixed|null|
	 */
	public static function month_chart_post_data() {
		$args = array(
			'author'      => get_option( 'tyw_user_profile_id' ),
			'post_type'   => array( 'page', 'post' ),
			'post_status' => 'publish',
			'date_query'  => array(
				array(
					'year' => date( 'Y' ),
				),
			),
		);

		$query = new \WP_Query( $args );

		$found_posts = array();
		$months      = array(
			'Jan' => 0,
			'Feb' => 0,
			'Mar' => 0,
			'Apr' => 0,
			'May' => 0,
			'Jun' => 0,
			'Jul' => 0,
			'Aug' => 0,
			'Sep' => 0,
			'Oct' => 0,
			'Nov' => 0,
			'Dec' => 0,
		);

		if ( null == $query->found_posts ) {
			return null;
		}

		foreach ( $query->posts as $post ) {
				$post_date = date( 'M', strtotime( $post->post_date ) );
				array_push( $found_posts, $post_date );
		}
		$result      = array_count_values( $found_posts );
		$found_posts = array_merge( $months, $result );

		$month_chart_data = array(
			array(
				'month_name' => 'Jan',
				'posts'      => $found_posts['Jan'],
			),
			array(
				'month_name' => 'Feb',
				'posts'      => $found_posts['Feb'],
			),
			array(
				'month_name' => 'Mar',
				'posts'      => $found_posts['Mar'],
			),
			array(
				'month_name' => 'Apr',
				'posts'      => $found_posts['Apr'],
			),
			array(
				'month_name' => 'May',
				'posts'      => $found_posts['May'],
			),
			array(
				'month_name' => 'Jun',
				'posts'      => $found_posts['Jun'],
			),
			array(
				'month_name' => 'Jul',
				'posts'      => $found_posts['Jul'],
			),
			array(
				'month_name' => 'Aug',
				'posts'      => $found_posts['Aug'],
			),
			array(
				'month_name' => 'Sep',
				'posts'      => $found_posts['Sep'],
			),
			array(
				'month_name' => 'Oct',
				'posts'      => $found_posts['Oct'],
			),
			array(
				'month_name' => 'Nov',
				'posts'      => $found_posts['Nov'],
			),
			array(
				'month_name' => 'Dec',
				'posts'      => $found_posts['Dec'],
			),
		);

		return json_encode( $month_chart_data );

	}

}

