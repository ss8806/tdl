<template>
  <header class="header">
    <div class="container">
      <router-link class="nav__left" to="/todos">
         <h1>Todo List</h1>
      </router-link>
       
        <ul class="nav nav__right" v-if="auth.length === 0">
            <li>
              <router-link id="header-nav__login" to="/login">ログイン</router-link>
            </li>
            <li>
              <router-link id="header-nav__register" to="/register">ユーザー登録</router-link>
            </li>
        </ul>

      <ul class="nav nav__right" v-if="auth.length !== 0">

        <li class="dropdown" 
        @mouseover="isOpen = !isOpen"
        @mouseout="isOpen = !isOpen"
        >
            {{this.$store.state.u_name}}
        
            <!-- 表示、非表示 -->
            <ul class="dropdown-menu" v-show="!isOpen" role="menu">
              <li>
                <router-link class="navbar" id="header-nav__mypage" to="/mypage">マイページ</router-link>
              </li>
              <li>
                <a class="navbar" id="header-nav__logout" @click="logout" >ログアウト</a>
                <form id="logout-form" action="/logout" method="POST" style="display: none;">
                  <input type="hidden" name="_token" :value="csrf" />
                </form>
              </li>
            </ul>
        </li>
      </ul>

    </div>
  </header>
</template>

<script>
export default {

  data() {
    return {
      isOpen: true,
      csrf: document
        .querySelector('meta[name="csrf-token"]') //layout.app.blade.phpより 要素を取得
        .getAttribute("content") // layout.app.blade.phpより属性を設定
    };
  },
  props: {
    auth: {
      type: Object | Array
    }
  },
  methods: {
    getUser(){
      this.$http.get("/api/user").then(response => {
      this.user = response.data;
      this.$store.state.u_name = this.user.name;

      })
      .catch((error) => {
      console.error('未ログイン', error);
      })
      .finally(() => {
        console.info('ローディング終了');
      });
    },
    logout(){
      document.querySelector("#logout-form").submit();
    }
  },
    mounted() {
    // authを使わないで取得する方法
    this.getUser();
    }
};
</script>


<style scoped>
  .header{
    width: 100%;
    background-color: aliceblue;
    position: fixed;
  }
  .container{
    display: flex;
    justify-content: space-between;
    margin-left: 30px;
    margin-right: 30px;
  }
  .nav__left{
    text-decoration: none;
    color: inherit;
  }
  .nav__right{
    margin-top: 10px;
    display: flex;
    justify-content: space-between;
  }
</style>