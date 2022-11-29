const path = require('path')

module.exports = {
    mode: "production",
    entry: {
        index: path.resolve(__dirname, 'views/js/webpack/index.js'),
        add: path.resolve(__dirname, 'views/js/webpack/add.js'),
        change: path.resolve(__dirname, 'views/js/webpack/change.js'),
        template: path.resolve(__dirname, 'views/js/webpack/template.js'),
        css: path.resolve(__dirname, 'views/js/webpack/css.js')
    },
    module: {
        rules: [
            {test: /\.css$/, use: ['style-loader','css-loader']}
        ]
    },
    output: {
        path: path.resolve(__dirname, 'views/dist'),
        filename: '[name].js',
    },
}