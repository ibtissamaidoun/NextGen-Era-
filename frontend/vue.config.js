//const { defineConfig } = require('@vue/cli-service')
// vue.config.js
const webpack = require('webpack');
module.exports = {
  configureWebpack: {
    plugins: [
      new webpack.ProgressPlugin()
    ]
  },
    transpileDependencies: ['vue-argon-dashboard-2'], // Mettez ici le nom de vos dépendances à transpiler
    devServer: {
      proxy: {
        '/api': {
          target: 'http://127.0.0.1:8000',
          changeOrigin: true,
          secure: false
        }
      }
    }
  };
  
