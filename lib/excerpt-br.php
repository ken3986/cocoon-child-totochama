<?php /* 抜粋のオーバーライド（改行反映） */

function get_the_snippet($content, $length = 70) {
  global $post;

  //抜粋（投稿編集画面）の取得
  // $description = $post->post_excerpt;
  $description = nl2br($post->post_excerpt); // ★改行を反映

  //SEO設定のディスクリプション取得
  if (!$description) {
    $description = get_the_page_meta_description($post->ID);
  }

  //SEO設定のディスクリプションがない場合は「All in One SEO Packの値」を取得
  if (!$description) {
    $description = get_the_all_in_one_seo_pack_meta_description();
  }

  //SEO設定のディスクリプションがない場合は「抜粋」を取得
  if (!$description) {
    $description = get_content_excerpt($content, $length);
    $description = str_replace('<', '&lt;', $description);
    $description = str_replace('>', '&gt;', $description);
  }
  return apply_filters( 'get_the_snippet', $description );
}