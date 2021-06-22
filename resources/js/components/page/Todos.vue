<template>
  <main>
        <div class="inputArea">
          <input
            class="inputText"
            placeholder="ここにTODO内容を書く"
            v-on:keydown.shift.enter="addItem"
            v-model="todoItem"
          />
          </div>
          <p class="error">
            {{Validation.result}}
          </p>

      <!-- <input type="hidden" name="_token" :value="csrf" /> -->
      <button
        v-on:click="addItem"
        class="btn add_todo"
      >TODOを追加
      </button>
      <!-- <button
        type="submit"
        class="btn save"
        value="Submit"
      >保存
      </button> -->

      <div class="searchBox">
        <i class="fa fa-search searchBox__icon"></i>
        <input
          type="text"
          class="searchBox__input"
          placeholder="キーワード検索"
          v-model="searchWord"
        />
      </div>

      <p>TODO内容をクリックで編集モード</p>
      <p class="description">shift と Enter 同時押しで編集を確定</p>

      <ul class="list">
        <transition-group name="fade">
          <li
            class="list__item"
            v-for="(item, index) in filteredItems"
            v-bind:key="item.id"
            v-bind:class="{'is-checked': item.ischecked}"
          >
            <!-- <input name="ischecked" type="hidden" value="0" />   -->
           
            <span
            class="fa"
              name = "ischecked" 
              v-on:click="changeIcon(item)"
              v-bind:class="{'fa-circle-thin icon-check': !item.ischecked , 'fa-check-circle icon-check': item.ischecked}"
              value = !item.ischecked;
            ></span>
              
              <!-- テキストを送る -->

              <span
              v-if="!item.edit"
              v-text="item.text" 
              v-on:click="changeEdit(item)">
              >
              </span>

              <input
                :type="text"
                v-if="item.edit"
                v-model="item.text"
                v-on:keydown.shift.enter="doUpdate(item, index)"
              >
            
            <i
              type ="button"
              class="fa fa-trash icon-trash"
              v-on:click="doRemove(item, index)"
            ></i>

          </li>
        </transition-group>
      </ul>
  </main>
</template>

<script>
export default {
    data: function() { // 初期値を入力
    return {
      items: [
        // { id: 1, text: "sample todo1", value: false, ischecked: false, edit:false},
      ],
      Validation:{
        result: "",
      },
      nextID: "",
      text: "",
      todoItem: "",
      searchWord: "",
      errors: [],
      csrf: document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content")
    };
  },
  computed: {
    filteredItems() {
      return this.searchItem(this.items, this.searchWord); // (list,key) itemsからitemを作成する
    }
  },
  methods: {
    addItem(){
      if (this.todoItem !== ""){
      // this.items.push({
      //   id: this.nextID++,
      //   text: this.todoItem,
      //   ischecked: false,
      //   edit: false, // 新しく追加したItemにもeditのプロパティが必要
      // })
      this.Validation.result=""; // validationを空にする。
      // 保存する処理
      this.$http.post("/api/todos",{
        text: this.todoItem,
        ischecked: false,
      })
    }else{
      this.Validation.result="入力してください";
    }
      this.todoItem = ""; //入力後に空にする。
      this.getTodoList();
    },

    doRemove(item, index) {
      // deleteでは動かないためpostにした
      this.$http.post("/api/todos/destroy",{
        id: item.id,
      })
       .then(function (response) {
         console.log(response);
      });
        this.items.splice(index, 1); //要素を削除してつなぎ合わせる 第二引数に１を指定しないと全てが消える
        console.log(this.items);
    },

    changeIcon(item) { //itemはv-forで作成 暗転する処理
      item.ischecked = item.ischecked ? 0: 1;
       this.$http.post("/api/todos/changeIcon",{
        id: item.id,
        ischecked: item.ischecked,
      })
       .then(function (response) {
         console.log(response);
      });
    },
    changeEdit(item){
      item.edit = true;
    },
    doUpdate(item, index) {
      item.edit = false;
        // 入力を空にしたら削除する
        if(item.text === '' ){
          this.$http.post("/api/todos/destroy",{
          id: item.id,
        })
        .then(function (response) {
          console.log(response);
        });
          this.items.splice(index, 1); //要素を削除してつなぎ合わせる 第二引数に１を指定しないと全てが消える
          console.log(this.items);
        }

      this.$http.post("/api/todos/update",{
        id: item.id,
        text: item.text,
      })
       .then(function (response) {
         console.log(response);
      });
    },
    searchItem(list, key) { // (items, searchWord)
      return list.filter(function(item) { //配列listからitemを絞り込む
        return item.text.indexOf(key) !== -1 || key === "";
        // 文字列.indexOf( 検索したい文字)
        // -1 は存在しない場合という意味、 !==-1 は存在する場合
      });
    },
    getTodoList() {
      this.$http.get("/api/todos")
        .then(response => {
          this.items = response.data;
          console.log(this.items);
        });
    }
  },
  mounted() { 
    this.getTodoList();
  },
};
</script>

<style scoped>
.section{
  background: #fff;
  padding: 15px;
  text-align: center;
  margin-bottom: 15px;
}
main{
  width: 400px;
  margin: 0px auto;
}
.mainTitle{
  text-align: center;
  font-size: 3em;
  color: rgb(0, 191, 255);
}
.form{
  text-align: right;
  margin-bottom: 30px;
}
.inputArea{
  margin-bottom: 15px;
}
.inputText{
  padding: 5px;
  height: 40px;
  font-size: 16px;
  width: 100%;
  box-sizing: border-box;
  border: 1px solid #999;
}
::-webkit-input-placeholder {
  color: #e8e8e8;
}
.btn {
  padding: 5px 20px;
  background: #999;
  color: #fff;
  border: none;
  margin: 0;
  font-size: 16px;
  margin-bottom: 20px;
}
.btn:hover{
  cursor: pointer;
}
.add_todo{
  float: left;
  background-color: lawngreen;
}

.save{
  float: right;
  background-color: green;
}

.error{
  color: #E9573E;
}
.searchBox{
  width: 100%;
  height: 40px;
  border: 1px solid #999;
  border-radius: 20px;
  margin-bottom: 15px;
  background: #fff;
  display: flex;
  align-items: center;
  padding: 0 10px;
  box-sizing: border-box;
}
.searchBox__icon{
  width: 16px;
  font-size: 18px;
  margin-right: 5px;
  color: #888;
}
.searchBox__input{
  width: calc(100% - 30px);
  height: 100%;
  border: none;
  box-sizing: border-box;
  padding: 5px 10px;
  font-size: 16px;
}
.list{
  list-style: none;
  padding: 0;
  margin: 0;
  box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.2), 0 25px 50px 0 rgba(0, 0, 0, 0.1);
}
.list__item{
  overflow: hidden;
  padding: 15px 15px;
  background: #fff;
  border-bottom: 1px solid #e8e8e8;
  transition: .5s transform;
}
.list__item:last-child{
  border-bottom: none;
}
.list__item:hover{
  transform: scale(1.02);
  transition: .5s transform;
}
.list__item--done{
  background: #e5e5e5;
  color: #888;
}
.icon-check{
  font-size: 25px !important;
  color: rgba(89, 158, 175, 0.29);
  vertical-align: middle;
}
.icon-square, .icon-check, .icon-sort, .icon-trash{
  cursor: pointer;
  transition: .5s transform;
}
.icon-square:hover, .icon-check:hover, .icon-sort:hover, .icon-trash:hover{
  transform: scale(1.2);
  transition: .5s transform;
}
.icon-trash{
  float: right;
  top: 4px;
  position: relative;
  color: rgba(175, 47, 47, 0.47);
}
.icon-square, .icon-check{
  margin-right: 15px;
}
.editText{
  /*display: none;*/
  width: 80%;
  height: 100%;
  border: none;
  padding: 5px 10px;
  font-size: 16px;
}
.is-checked{
  background: #d8d8d8;
  color: #888;
}
input{
  width: 80%;
  box-sizing:border-box;
}

.checkbox {
  display: none;
}
.checkbox-fontas {
  position: relative;
  vertical-align: middle;
  font-size: 21px;
}
.checkbox + .checkbox-fontas:before {
  font-weight: 900;
  font-family: "Font Awesome 5 Free";
  content: '\f00c';
  color: #ccc;
}
.checkbox:checked + .checkbox-fontas:before {
  color: #2db29c;
}
.checkbox{
  display: none;
}
.check{
  width: 5%;
}
.description{
  padding-bottom: 20px;
}
</style>
