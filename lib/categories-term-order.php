<?php /* カテゴリーリストを親から順に取得 */
/**
 * 参照
 * WordPress の get_the_category で親、子、孫の階層表示をする関数を作成！
 * https://eigo-shutoku.com/get-the-category-hierarchical-order/
 */

/**
* 使い方
* categories_term_order(get_the_category());
*/

/**
 * Order by term_order
 */
function categories_term_order( $categories ) {
	$category_tree = [];
	$branches = [];

	/*
	 * Here $categories has a list of items in random order like this
	 * This is just an example ok. This kind of category structure should never be made
	 *
	 *	array(
	 * 		0 => {
	 *			'term_id' => 26,
	 * 			'parent' => 4,
	 * 		},
	 * 		1 => {
	 *			'term_id' => 39,
	 * 			'parent' => 2,
	 * 		},
	 * 		2 => {
	 *			'term_id' => 45,
	 * 			'parent' => 25,
	 * 		},
	 * 		3 => {
	 *			'term_id' => 4,
	 * 			'parent' => 25,
	 * 		},
	 * 		4 => {
	 *			'term_id' => 2,
	 * 			'parent' => 0,
	 * 		},
	 * 		5 => {
	 *			'term_id' => 53,
	 * 			'parent' => 25,
	 * 		},
	 * 		6 => {
	 *			'term_id' => 25,
	 * 			'parent' => 0,
	 * 		}
	 *	)
	 *
	 *	Let's go!
	 */

	foreach( $categories as $cat ) {
		if ( 0 === $cat->category_parent ) {
			$category_tree[ $cat->term_id ] = [];
		} else {
			$branches[ $cat->category_parent ][ $cat->term_id ] = '';
		}
	}

	/*
	 * Now it looks like this
	 *
	 *	$category_tree = (
	 *		2 => array(),
	 *		25 => array(),
	 *	)
	 *	$branches = (
	 *		4 => array(
	 *			26 => '',
	 *		),
	 *		2 => array(
	 *			39 => '',
	 *		),
	 *		25 => array(
	 *			45 => '',
	 *			4 => '',
	 *			53 => '',
	 *		),
	 *	)
	 *
	 * This means 2 and 25 are the oldest ancestors
	 * 26 is a child of 4
	 * 39 is a child of 2
	 * 45 is a child of 25
	 * 4 is a child of 25
	 * 53 is a child of 25
	 *
	 * Let's insert each branch into $category_tree!
	 */

	if ( count( $branches ) ) {
		foreach( $branches as $foundation => $branch ) {
			foreach( $branches as $key => $val ) {
				if ( array_key_exists( $foundation, $val ) ) {
					$branches[ $key ][ $foundation ] = $branches[ $foundation ];
					break 1;
				}
			}
		}
		foreach ( $branches as $foundation => $branch ) {
			if ( isset( $category_tree[ $foundation ] ) ) {
				$category_tree[ $foundation ] = $branch;
			} else {

				/*
				 * This else is when $category_tree and $branches look like these
				 *
				 *	$category_tree = (
				 *		2 => array(),
				 *		25 => array(),
				 *	)
				 *	$branches = (
				 *		4 => array(
				 *			26 => '',
				 *		),
				 *	)
				 *
				 *	This means category 2, 25 and 26 are set but not 4. So 26 is like a lost child
				 *
				 *	The code below makes $category_tree like this
				 *
				  *	$category_tree = (
				 *		2 => array(),
				 *		25 => array(),
				 *		26 => array(),
				 *	)
				 */

				$category_tree += [ key( $branch ) => [] ];
			}
		}
	}

	/*
	 * Now $category_tree looks like this
	 *	array(
	 *		2 => array(
	 * 			39 => '',
	 * 		),
	 * 		25 => array(
	 * 			45 => '',
	 * 			4 => array(
	 * 				26 => '',
	 * 			),
	 * 			53 => '',
	 * 		),
	 * 	)
	 *
	 * Let's flatten it!
	 */

	// multidimensional array flatten
	$array_flatten = function ( $array ) use ( &$array_flatten ) {
		$return = [];

		foreach( $array as $key => $val ) {
			$return[] = $key;

			if ( is_array( $array[ $key ] ) ) {
				$return = array_merge( $return, $array_flatten( $array[ $key ] ) );
			}
		}
		return $return;
	};
	$category_tree = $array_flatten( $category_tree );

	// $category_tree += [ key( $branch ) => [] ]; might make a redundant element in an array
	$category_tree = array_unique( $category_tree );

	/*
	 * Now $category_tree looks like this
	 *	array(
	 *		0 => 2,
	 *		1 => 39,
	 *		2 => 25,
	 *		3 => 45,
	 *		4 => 4,
 	 *		5 => 26,
 	 *		6 => 53,
	 *	)
	 *
	 * Let's insert category data into where it should be
	 * Take it easy
	 */

	foreach ( $category_tree as $key => $cat ) {
		foreach ( $categories as $k => $c ) {
			if ( $cat === $c->term_id ) {
				$category_tree[ $key ] = $c;
			}
		}
	}
	return $category_tree;
}