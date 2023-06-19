const mix = require('laravel-mix');
const path = require('path');
const fs = require('fs');

require('laravel-mix-polyfill');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.webpackConfig({
  module: {
    rules: [
      {
        enforce: 'pre',
        exclude: /node_modules/,
        loader: 'eslint-loader',
        test: /\.(js|vue)?$/,
      },
    ],
  },
});

mix
  .setPublicPath('public')
  .alias({
    '@': path.join(__dirname, 'resources'),
  })
  .js('resources/js/app.js', 'public/js')
  .sass('resources/scss/main.scss', 'css', {
    // Import normalize.css
    // additionalData: [
    //   fs.readFileSync('node_modules/normalize.css/normalize.css').toString(),
    // fs
    //   .readFileSync('node_modules/tarteaucitronjs/css/tarteaucitron.css')
    //   .toString(),
    // ].join(';'),
  })
  .vue({
    extractStyles: true,
    options: {},
  })
  .options({
    terser: {
      terserOptions: {
        format: {
          comments: false,
        },
      },
      extractComments: false,
    },
  })
  .polyfill({
    enabled: true,
    useBuiltIns: 'usage', // https://babeljs.io/docs/en/babel-preset-env#usebuiltins-usage
    targets: false, // Set to `false` to use .browserslistrc
  })
  // Update devType depending on your needs (speed vs quality)
  // See https://webpack.js.org/configuration/devtool/#devtool
  .sourceMaps(false, 'source-map')
  // .copy('resources/images/public', 'public/images')
  // Uncomment following lines to enable BrowserSync
  //.browserSync({
  //  // Keep access to `localhost`
  //  host: 'localhost',
  //  // Container running apache service
  //  proxy: 'php-apache',
  //  // Internally exposed port
  //  port: 3000,
  //  // Don't auto-open browser (didin't work in container)
  //  open: false,
  //  // Force HTTPS
  //  https: true,
  //  // Disable unaccessible BrowserSync's UI
  //  ui: false,
  //})
  .version(['public/images']);
