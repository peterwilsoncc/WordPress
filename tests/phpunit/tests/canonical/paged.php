<?php
/**
 * @group canonical
 * @group rewrite
 * @group query
 */
class Tests_Canonical_Paged extends WP_Canonical_UnitTestCase {

	function test_nextpage() {
		$para = 'This is a paragraph.
			This is a paragraph.
			This is a paragraph.';
		$next = '<!--nextpage-->';

		$post_id = self::factory()->post->create( array(
			'post_status' => 'publish',
			'post_content' => "{$para}{$next}{$para}{$next}{$para}"
		) );

		$link = parse_url( get_permalink( $post_id ), PHP_URL_PATH );
		$paged = $link . '4/';

		$this->assertCanonical( $paged, $link );
	}

	/**
	 * Ensure paged canonical redirect applies to pages.
	 *
	 * @ticket 28081
	 */
	function test_page_with_paged_query_var() {
		$post_id = self::factory()->post->create( array(
			'post_status'  => 'publish',
			'post_title'   => 'Alexander Hamilton.',
			'post_content' => 'My name is Alexander Hamilton.',
			'post_type'    => 'page',
		) );

		$link = parse_url( get_permalink( $post_id ), PHP_URL_PATH );
		$paged = $link . 'page/3/';

		$this->assertCanonical( $paged, $link );
	}
}
