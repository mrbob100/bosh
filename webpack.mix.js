const mix = require('laravel-mix');
const MiniCssExtractPlugin=require('mini-css-extract-plugin');
const  BundleAnalyzerPlugin  = require ('webpack-bundle-analyzer').BundleAnalyzerPlugin;

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


mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css').version()
    .sourceMaps();
//mix.extract(['vue','lodash','quill','chart','element-ui','moment','vue-carousel-3d','vue-social-auth']);



mix.webpackConfig({

    output: {
        filename: '[name].js',
        chunkFilename: '[name].js',
    },

    resolve: {
        alias: {
            'vue$': 'vue/dist/vue.runtime.common.js'
        }
    },
    performance: {
        hints: false,
        maxEntrypointSize: 512000,
        maxAssetSize: 512000,
    },

    plugins: [
        new MiniCssExtractPlugin({
            filename: `[name].css`,
        }),
        // new BundleAnalyzerPlugin()
    ]

});


