import Vue from 'vue'
import Router from 'vue-router'
import Mypage from './components/page/Mypage'
import Top from './components/page/Top'
import Todos from './components/page/Todos'
import Login from './components/page/Login'
import Register from './components/page/Register'

Vue.use(Router)

const router = new Router({ //export default new Router({ から変更
  mode: 'history', // SPAのURLにはhistoryモード(#ハッシュが付かないタイプを使います)
  routes: [
    {
      path: '/',
      name: 'top',
      component: Top, // URL「/todos」に対してHomeコンポーネントを使うという意味です
    },
    {
      path: '/todos',
      name: 'todos',
      component: Todos, // URL「/todos」に対してHomeコンポーネントを使うという意味です
      meta: {requiresAuth: true}
    },
    {
      path: '/mypage',
      name: 'mypage',
      component: Mypage, // URL「/todos」に対してHomeコンポーネントを使うという意味です
      meta: {requiresAuth: true}
    },
    {
      path: '/login',
      name: 'login',
      component: Login
    },   
    {
      path: '/register',
      name: 'register',
      component: Register
    },
  ]
});
router.beforeEach((to, from, next) => {
  if (to.matched.some(rec => rec.meta.requiresAuth)) { // ログインしているならtrueで直下の処理、なければnext
    router.app.$http.get("/api/user").then(response => { // Vue.prototype.$http = axios;を設定していますので、router.app.$httpでAxiosを呼び出すことができます。
      const user = response.data; // 取得したjsonを userに代入
      if (user) {
        next()
      } else {
        next({
          path: '/login',
        })
      }
    }).catch(error => {
      if (error.response.status === 401) {
        alert("未認証のユーザーのためログイン画面でログインを行ってください");
      } else {
        alert("予期しないエラーが発生しました。再度ログインを行ってください");
      }
      next({
        path: '/login',
      })
    });
  } else {
    next()
  }
})
export default router