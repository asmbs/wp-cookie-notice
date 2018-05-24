const path = require( 'path' );
const ExtractTextPlugin = require( 'extract-text-webpack-plugin' );
const webpack = require( 'webpack' );

module.exports = {
    entry: './js/src/main.js',
    output: {
        filename: 'scripts.js',
        path: path.resolve( __dirname, 'js' )
    },
    externals: {
        jquery: 'jQuery'
    },
    mode: 'production',
    module: {
        rules: [

            // Run JS through Babel Loader before bundling it to `scripts.js`
            {
                test: /\.js$/,
                exclude: /node_modules/,
                loader: 'babel-loader'
            },

            // Run Sass through loaders before bundling into `style.css`
            {
                test: /\.scss$/,
                enforce: 'pre',
                loader: ExtractTextPlugin.extract([
                    {
                        loader: 'css-loader',
                        options: {
                            minimize: true,
                            sourceMap: true
                        }
                    },
                    {
                        loader: 'sass-loader'
                    }
                ])
            },
            {
                enforce: 'pre',
                test: /\.js$/,
                exclude: /node_modules/,
                loader: 'eslint-loader',
                options: {
                    emitWarning: true
                }
            }
        ]
    },
    plugins: [
        new ExtractTextPlugin({
            filename: '../css/style.css'
        }),
        new webpack.ProvidePlugin({
            $: 'jquery',
            jQuery: 'jquery'
        })
    ]
}
