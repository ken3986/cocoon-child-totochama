// pathモジュールの読み込み
const path = require('path');

// MiniCssExtractPluginの読み込み
const MiniCssExtractPlugin = require("mini-css-extract-plugin");

// BrowserSyncPluginの読み込み
const BrowserSyncPlugin = require('browser-sync-webpack-plugin');

module.exports = {
  // メインとなるJavaScriptファイル（エントリーポイント）
  entry: `./src/index.js`,

  // ファイルの出力設定
  output: {
    //  出力ファイルのディレクトリ名（絶対パス指定）
    path: path.resolve(__dirname),
    // 出力ファイル名
    filename: "main.js"
  },
  module: {
    rules: [
      {
        // 対称となるファイルの拡張子
        test: /\.scss$/,

        // 処理対象から外すファイル
        exclude: /node_modules/,

        use: [
          // CSSファイルを抽出するようにMiniCssExtractPluginのローダーを指定
          {
            loader: MiniCssExtractPlugin.loader,
          },
          // CSSをバンドルするためのローダー
          {
            loader: "css-loader",
            options: {
              // URLの解決を無効に
              url: false,
              // ソースマップを有効に
              sourceMap: true,
            },
          },
          // SassをCSSへ変換するローダー
          {
            loader: "sass-loader",
            options: {
              // dart-sassを優先
              implementation: require('sass'),
              sassOptions: {
                // fibersを使わない場合は以下でfalseを指定
                fiber: require('fibers'),
              },
              // ソースマップを有効に
              sourceMap: true,
            },
          },
        ],
      },
    ],
  },

  // プラグインの設定
  plugins: [
    new MiniCssExtractPlugin({
      // 抽出するCSSのファイル名
      filename: 'style.css',
    }),
    new BrowserSyncPlugin({
      host: 'localhost',
      port: 3000,
      proxy: 'http://localhost:8080/TSUKURIKAKE_WP/',
    }),
  ],
  // source-mapタイプのソースマップを出力
  devtool: "source-map",
  // node_modulesを監視（watch）対象から除外
  watchOptions: {
    ignored: /node_modules/
  },
};
