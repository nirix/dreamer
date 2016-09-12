var path = require('path');
var webpack = require('webpack');

module.exports = {
    entry: {
        dreamer: './src/assets/main.js',
        admin: './src/assets/admin.js'
    },
    output: {
        path: "./public/assets",
        filename: "[name].js"
    },
    module: {
        loaders: [
            {
                test: /\.css$/,
                loaders: ["style", "css"]
            },
            {
                test: /\.sass$/,
                loaders: ["style", "css", "sass"]
            },
            {
                test: /\.scss$/,
                loaders: ["style", "css", "sass"]
            },
            {
                test: /\.js$/,
                loader: "babel",
                query: {
                    presets: ["react", "es2015"]
                }
            }
        ]
    },
    plugins: [
        new webpack.ProvidePlugin({
            $: 'jquery',
            jQuery: 'jquery',
            jquery: 'jquery',
            marked: 'marked'
        })
    ],
    sassLoader: {
        includePaths: [
            path.resolve(__dirname, "node_modules/bootstrap-sass/assets/stylesheets")
        ]
    }
};
