// webpack.mix.js
require('dotenv').config();

let mix = require('laravel-mix');

mix
.options({
  processCssUrls: false,
})
.sass('src/scss/style.scss', './style.css')
.browserSync({
  files: [
    "src/**/*",
    "dist/**/*.*"
  ],
  proxy: {
      target: process.env.SiteUrl, //ここにurl
  }
});
