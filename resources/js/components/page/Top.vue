<template>
  <div>
    <main>
      <h1 class="title"> Todo List</h1>
      <div class="container">
        <div>
          <p>初めて方は</p>
          <router-link id="header-nav__register" to="/register">ユーザー登録</router-link>
        </div>
        <div>
          <p>登録済みの方は</p>
          <router-link id="header-nav__login" to="/login">ログイン</router-link>
        </div>
      </div>
    </main>
  </div>
</template>

<script>
export default {

};
</script>

<style scoped>
  .title{
    text-align: center;
  }
  .content{
    text-align: center;
  }
  .container{
    display: flex;
    justify-content: space-evenly;
    margin-left: 30px;
    margin-right: 30px;
    padding-top: 50px;
  }
</style>