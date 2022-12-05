const miniCss = require("mini-css-extract-plugin");
const path = require("path");

module.exports = {
    mode: 'development',
    entry: {
        "main":
            [
                "./src/js/app.js",
                "./src/scss/main.scss",
            ],
        "demandeur":
            [
                "./src/scss/tools/_color_demandeur.scss"
            ],
        "intervenant":
            [
                "./src/scss/tools/_color_intervenant.scss"
            ]
    },
    output: {
        path: path.resolve(__dirname, '../prod/js'),
        filename: "[name].min.js"
    },
    module: {
        rules: [{
            test:/\.(s*)css$/,
            use: [
                {
                    loader: miniCss.loader,
                    options: {
                        publicPath: ''
                    }
                },
                'css-loader',
                'sass-loader',
            ]
        },
        {
            test: /\.(woff(2)?|ttf|eot|svg)(\?v=\d+\.\d+\.\d+)?$/,
            use: [
                {
                    loader: 'file-loader',
                    options: {
                        name: '[name].[ext]',
                        outputPath: '../fonts/'
                    }
                }
            ]
        }]
    },
    plugins: [
        new miniCss({
            filename: "../css/[name].min.css",
        }),
    ]
};
