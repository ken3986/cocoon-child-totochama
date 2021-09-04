<?php

get_template_part('lib/parent-category-label');
get_template_part('lib/excerpt-br');
get_template_part('lib/widget-area-index-bottom-plus');
get_template_part('lib/categories-term-order');

// 更新の確認
require 'lib/plugin-update-checker/plugin-update-checker.php';
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
  'https://github.com/ken3986/cocoon-child-totochama',
  __FILE__,
  'cocoon-child-totochama'
);
$myUpdateChecker -> getVcsApi() -> enableReleaseAssets();
