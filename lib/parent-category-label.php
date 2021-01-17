<?php /* カテゴリラベル（アイキャッチのカテゴリ表示）を親カテゴリで統一する */

// 参考：【Cocoon】カテゴリラベル表示のカスタム方法⇒『親カテゴリ表示に統一』『子カテゴリ表示に統一』『カテゴリ毎に指定』 | あられブログ
// https://arare-blog.com/categorylabel-customer01
function get_the_nolink_category($id = null, $is_visible = true){
  if ($id) {
    $categoryArray = get_the_category($id);
  } else {
    $categoryArray = get_the_category();
  }
  $display_class = null;
  if (!$is_visible) {
    return;
  }
  if (isset($categoryArray[0])) {
    $ret = $categoryArray[0];
    foreach($categoryArray as $category)
    {
      if($category->category_parent == 0)
        {
          $ret = $category;
          break;
        }
      }
    return '<span class="cat-label cat-label-'.$ret->cat_ID.'">'.$ret->cat_name.'</span>';
  }
}