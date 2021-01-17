<?php 

function tt_get_cocoon_list_index_func($atts, $content = "") {
  $atts = shortcode_atts(array(
    'category_id' => '',
  ), $atts, 'tt-get-cocoon-list-index');

  global $post;
  $args = array(
    'category_id' => $atts['category_id'],
  );

  $myposts = get_posts($args);

  $returnHtml = '';
  $returnHtml .= '<div id="list" class="'. get_index_list_classes().'">';
  $count = 0;
  if($myposts):
    foreach($myposts as $post):
      setup_postdata($post);
      $count++;
      set_query_var('count', $count);

        if ( !defined( 'ABSPATH' ) ) exit;
        $article_id_attr = null;
        if (is_front_page_type_index()) {
          $article_id_attr = ' id="post-'.get_the_ID().'"';
        }

        $returnHtml .= '<a href="'. esc_url(get_the_permalink()). '" class="entry-card-wrap a-wrap border-element cf" title="'. esc_attr(get_the_title()). '">';
          $returnHtml .= '<article'. $article_id_attr. get_post_class(array('post-'.get_the_ID(), 'entry-card','e-card', 'cf')). '>';
            $returnHtml .= '<figure class="entry-card-thumb card-thumb e-card-thumb">';
              //サムネイルタグを取得
              $thumbnail_tag =
              get_the_post_thumbnail(
                get_the_ID(),
                get_entry_card_thumbnail_size($count),
                array(
                  'class' => 'entry-card-thumb-image card-thumb-image',
                  'alt' => ''
                )
              );
              // サムネイルを持っているとき
              if ( has_post_thumbnail() && $thumbnail_tag ):
                $returnHtml .= $thumbnail_tag;
              else: // サムネイルを持っていないとき
                $returnHtml .= get_entry_card_no_image_tag($count);
              endif;
              $returnHtml .= get_the_nolink_category(null, apply_filters('is_entry_card_category_label_visible', true)); //カテゴリラベルの取得>
            $returnHtml .= '</figure>';

            $returnHtml .= '<div class="entry-card-content card-content e-card-content">';
              $returnHtml .= '<h2 class="entry-card-title card-title e-card-title" itemprop="headline">'. get_the_title(). '</h2>';
              // スニペットの表示
              if (is_entry_card_snippet_visible()):
                $returnHtml .= '<div class="entry-card-snippet card-snippet e-card-snippet">';
                  $returnHtml .= get_the_snippet( get_the_content(''), get_entry_card_excerpt_max_length() ); //カスタマイズで指定した文字の長さだけ本文抜粋
                $returnHtml .= '</div>';
              endif;
            $returnHtml .= '</div>'; /* .entry-card-content */
          $returnHtml .= '</article>';
        $returnHtml .= '</a>';


    endforeach;
    $count = 0;
    wp_reset_postdata();
    $returnHtml .= '</div>';
  endif;

  return $returnHtml;
}
add_shortcode('tt-get-cocoon-list-index', 'tt_get_cocoon_list_index_func');