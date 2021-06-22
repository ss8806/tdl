<template>
  <div>
    <main>
      <div class="p-card--scaff">

        <h2 class="p-card p-card__header">名前を編集</h2>
        <div class="p-card p-card__body">
            <div class="p-form__group">          
                <input name="name" id="name" class="inputText"  v-model="user.name"/>                 
                <label for="name">(10文字以内)</label>
                <br>
                <button v-on:click="editName" class="c-btn">変更を保存</button>
            </div>
        </div>

      </div>
    </main>
  </div>
</template>

<script>
export default {
  data() {
    return {
      user: {},
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
  methods:{
    editName(){
      this.$http.post("/api/mypage/editName",{
        id: this.user.id, // thisはインスタンス自身
        name: this.user.name,
      })
        .then(function (response) {
          alert("名前を変更しました");
      });
      this.getUser();
    },
    onImageUploaded(e) {
      // event(=e)から画像データを取得する
      const image = e.target.files[0]
      this.createImage(image)
    },
    getUser(){
      this.$http.get("/api/user").then(response => {
      this.user = response.data;
      this.$store.state.u_name = this.user.name;

      // console.log(this.user.name);
      // console.log(this.$store.state.u_name);
      });
    }
  },
  mounted() {
    // authを使わないで取得する方法
    this.getUser();

    document.querySelector('.js-image-picker input')
      .addEventListener('change', (e) => {
        const input = e.target;
        const reader = new FileReader(); //FileReaderクラスのインスタンスを作成
        reader.onload = (e) => {
        // 以下から、画像を読み込んだ後の処理を記述する
            // クラス属性js-image-pickerを指定
            input.closest('.js-image-picker').querySelector('img').src = e.target.result
        };
// 第一引数にFileクラスのオブジェクトを指定する。ここではinputタグのDOMのfilesフィールドに格納されている、Fileオブジェクトを指定してる。
           reader.readAsDataURL(input.files[0]); 
      });
  }
  
};
</script>

<style scoped>
.p-card--scaff{
        text-align: center;
        margin: 30px auto;
        margin-bottom: 20px;
        background-color:white;
        padding: 10px 0;
    }
.u-display--none{
  display: none;
}
.inputText{
  padding: 5px;
  height: 30px;
  font-size: 12px;
  width: 150px;
  box-sizing: border-box;
  border: 1px solid #999;
}
.c-btn{
  margin: 10px;
}
</style>>