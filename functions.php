<?php //子テーマ用関数
if ( !defined( 'ABSPATH' ) ) exit;

//子テーマ用のビジュアルエディタースタイルを適用
add_editor_style();

//以下に子テーマ用の関数を書く
class voiceWidget extends WP_Widget{
 
  //コンストラクタ
  function __construct(){
  // 親コンストラクタの設定
      parent::__construct(
    // ウィジェットID 
    'test_widget_id01',
    // ウィジェット名
    'ランダムボイス',        
    // ウィジェットの概要
          array('description' => 'ランダムにセリフを出力するウィジェットです。')
      );
  }

  /**
 * ウィジェットの表示用関数
   *-------------------------------------------------------
 * @param array $args      [register_sidebar]で設定した
 *                         「before_title, after_title, 
 *                          before_widget, after_widget」が入る
   * @param array $instance  Widgetの設定項目
 * ------------------------------------------------------
*/
  public function widget($args, $instance){

  // 乱数取得
  $randomNum = rand(0, 3);
  // 文字列を入れる変数を用意
  $word = "けつばん";

  // 乱数によって文字列を変更する
  if ($randomNum === 0) {
    $word = "ゼロ番目だよ";
  } elseif  ($randomNum === 1) {
    $word = "イチ番目だよ";
  } elseif  ($randomNum === 2) {
    $word = "ニ番目だよ";
  }

  // ウィジェット内容の前に出力
  echo $args['before_widget'];

  // ウィジェットの内容出力
  echo "<h1>ランダムボイス</h1>";

  echo "<p>". $word . "</p>";

  // ウィジェット内容の後に出力
      echo $args['after_widget'];
  }
}

add_action(
  'widgets_init',
  function(){
  // ウィジェットのクラス名を記述
      register_widget('voiceWidget'); 
  }
);