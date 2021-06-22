<template>
  <footer class="footer">
    <div class="container">
      <small class="sm">© 2021 Todolist. All rights reserved.</small>
    </div>
  </footer>
</template>

<style scoped>
  .footer{
    width: 100%;
    background-color: aquamarine;
    position: fixed;/*←絶対位置*/
    bottom: 0; /*下に固定*/
  }
  .container{
    display: flex;
    justify-content: flex-end;
  }
  body {
  padding: 20px;
  font-family: Helvetica;
}

#app {
  background: #fff;
  border-radius: 4px;
  padding: 20px;
  transition: all 0.2s;
  text-align:center;
}

.dropdown, .dropleft, .dropright, .dropup {
  display: inline-block;
}
</style>