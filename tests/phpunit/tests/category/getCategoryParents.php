<?php

/**
 * @group taxonomy
 */
class Tests_Category_GetCategoryParents extends WP_UnitTestCase {
	static $c1;
	static $c2;

	public static function wpSetUpBeforeClass( $factory ) {
		self::$c1 = $factory->category->create_and_get();
		self::$c2 = $factory->category->create_and_get( array(
			'parent' => self::$c1->term_id,
		) );
	}

	public function test_should_return_wp_error_for_invalid_category() {
		$this->assertWPError( get_category_parents( '' ) );
	}

	public function test_with_default_parameters() {
		$expected = self::$c1->name . '/'. self::$c2->name . '/';
		$found = get_category_parents( self::$c2->term_id );
		$this->assertSame( $expected, $found );
	}

	public function test_link_true() {
		$expected = '<a href="' . get_category_link( self::$c1->term_id ) . '">' . self::$c1->name . '</a>/<a href="' . get_category_link( self::$c2->term_id ) . '">'. self::$c2->name . '</a>/';
		$found = get_category_parents( self::$c2->term_id, true );
		$this->assertSame( $expected, $found );
	}

	public function test_separator() {
		$expected = self::$c1->name . ' --- ' . self::$c2->name . ' --- ';
		$found = get_category_parents( self::$c2->term_id, false, ' --- ', false );
		$this->assertSame( $expected, $found );
	}

	public function test_nicename_false() {
		$expected = self::$c1->name . '/'. self::$c2->name . '/';
		$found = get_category_parents( self::$c2->term_id, false, '/', false );
		$this->assertSame( $expected, $found );
	}

	public function test_nicename_true() {
		$expected = self::$c1->slug . '/'. self::$c2->slug . '/';
		$found = get_category_parents( self::$c2->term_id, false, '/', true );
		$this->assertSame( $expected, $found );
	}

	public function test_deprecated_argument_visited() {
		$this->setExpectedDeprecated( 'get_category_parents' );
		$found = get_category_parents( self::$c2->term_id, false, '/', false, array( self::$c1->term_id ) );
	}

	public function test_category_without_parents() {
		$expected = self::$c1->name . '/';
		$found = get_category_parents( self::$c1->term_id );
		$this->assertSame( $expected, $found );
	}
}
