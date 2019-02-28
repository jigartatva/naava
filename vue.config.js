const host = 'localhost';
const port = 8080;
/* eslint linebreak-style: ["error", "windows"] */
module.exports = {
  lintOnSave: false,
  publicPath: process.env.NODE_ENV === 'production' ? '/team4/naavaapp/' : '/',
  devServer: {
    port,
    host,
    hotOnly: true,
    disableHostCheck: true,
    clientLogLevel: 'warning',
    inline: true,
    headers: {
      'Access-Control-Allow-Origin': '*',
      'Access-Control-Allow-Methods': 'GET, POST, PUT, DELETE, PATCH, OPTIONS',
      'Access-Control-Allow-Headers': 'X-Requested-With, content-type, Authorization'
    },
  },
};
