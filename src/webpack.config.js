var Encore = require('@symfony/webpack-encore');
var CopyWebpackPlugin = require('copy-webpack-plugin');

Encore
    // directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // public path used by the web server to access the output path
    .setPublicPath('/build')
    // only needed for CDN's or sub-directory deploy
    //.setManifestKeyPrefix('build/')

    /*
     * ENTRY CONFIG
     *
     * Add 1 entry for each "page" of your app
     * (including one that's included on every page - e.g. "app")
     *
     * Each entry will result in one JavaScript file (e.g. app.js)
     * and one CSS file (e.g. app.css) if you JavaScript imports CSS.
     */
    .addEntry('app', './assets/js/app.js')
    .addEntry('home', './assets/js/home.js')
    .addEntry('security', './assets/js/security.js')
    .addEntry('contact', './assets/js/contact.js')
    .addEntry('admin', './assets/js/admin_base.js')
    .addEntry('kittens', './assets/js/kittens.js')
    .addEntry('admin_kitten_edit', './assets/js/admin_kitten_edit.js')
    .addEntry('kitten_detail', './assets/js/kitten_detail.js')
    .addEntry('about_us', './assets/js/about_us.js')
    .addEntry('cats', './assets/js/cats.js')
    .addEntry('posts', './assets/js/posts.js')
    .addEntry('strain', './assets/js/strain.js')
    .addEntry('admin_cat_edit', './assets/js/admin_cat_edit.js')
    .addEntry('admin_edit', './assets/js/admin_edit.js')

    // will require an extra script tag for runtime.js
    // but, you probably want this, unless you're building a single-page app
    .enableSingleRuntimeChunk()

    /*
     * FEATURE CONFIG
     *
     * Enable & configure other features below. For a full
     * list of features, see:
     * https://symfony.com/doc/current/frontend.html#adding-more-features
     */
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    // enables hashed filenames (e.g. app.abc123.css)
    .enableVersioning(Encore.isProduction())

    // enables Sass/SCSS support
    .enableSassLoader()

    // uncomment if you use TypeScript
    //.enableTypeScriptLoader()

    // uncomment if you're having problems with a jQuery plugin
    //.autoProvidejQuery()

    // uncomment if you use API Platform Admin (composer req api-admin)
    //.enableReactPreset()
    //.addEntry('admin', './assets/js/admin.js')

    .addPlugin(new CopyWebpackPlugin([
        { from: './assets/images', to: 'images' }
    ]))
;

module.exports = Encore.getWebpackConfig();
