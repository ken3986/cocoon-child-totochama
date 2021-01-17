<?php /* インデックスリストボトム＋ */

/**
 * ページネーションの下にもウィジェットエリアが欲しかったというだけのやつ。
 */

function register_index_bottom_plus_widget_area(){
  register_sidebars(1,
    array(
      'name' => 'インデックスリストボトム＋',
      'id' => 'index-bottom-plus',
      'description' => 'cocoonの「インデックスリストボトム」の少し下、ページネーションの下に表示されます。',
      'before_widget' => '<aside id="%1$s" class="widget widget-index-bottom-plus %2$s">',
      'after_widget' => '</aside>',
      'before_title' => '<div class="widget-index-bottom-plus-title main-widget-label">',
      'after_title' => '</div>',
    ));
}
register_index_bottom_plus_widget_area();