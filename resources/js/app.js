import Vue from 'vue'
import router from './router.js'
import axios from 'axios'
import store from './store'
import MainPage from './components/page/MainPage'
global.jQuery = global.$ = require('jquery');
require('bootstrap');

Vue.prototype.$http = axios; // Vueオブジェクトの$httpメソッドにaxiosを追加

axios.defaults.headers.common['Authorization'] = "Bearer " + document
  .querySelector('meta[name="api-token"]')
  .getAttribute("content");

new Vue({
  el: '#app',
  store,
  router: router, // routerにはrouter.jsファイルを設定します
  components: {
    app: MainPage //こちらのコードを追加することで、MainPageコンポーネントをbladeで<app />の記述で読み込めるようなる。
  }
}).$mount('#app') // layout.app.blade.php用の設定