<template>
  <div>
    <main>
      <div class="container" v-if="auth.length === 0">
        <div class="row">
              <div class="p-title">ユーザー登録</div>
<!-- Laravelは$errorsというグローバルなエラー情報を持っています。 -->
              <div class="form-group has-error" v-if="errors.length !== 0">
                <div class="alert alert-danger text-center">
                  ユーザー登録実行時にエラーが発生しました
                  <div v-for="(error, key, index) in errors" :key="index">{{error}}</div>
                </div>
              </div>

              <div class="panel-body">
                <ValidationObserver
                  class="form-horizontal"
                  ref="observer"
                  action="/register"
                  id="register"
                  method="post"
                  tag="form"
                  @submit.prevent="register()"
                >
                  <input type="hidden" name="_token" :value="csrf" />
                  <div class="form-group">
                    <label for="name" class="label">名前</label>

                    <div class="col-md-6">
                      <validation-provider name="名前" rules="required|max:20" v-slot="{ errors }">
                        <input v-model="name" name="name" type="text" class="inputText" />
                        <div class="alert alert-danger" v-show="errors[0]">{{ errors[0] }}</div>
                      </validation-provider>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="email" class="label">メールアドレス</label>

                    <div class="c-valid">
                      <validation-provider
                        name="メールアドレス"
                        rules="required|email"
                        v-slot="{ errors }"
                      >
                        <input v-model="email" name="email" type="email" class="inputText" />
                        <div class="alert alert-danger" v-show="errors[0]">{{ errors[0] }}</div>
                      </validation-provider>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="password" class="label">パスワード</label>

                    <div class="c-valid">
                      <validation-provider
                        name="パスワード"
                        rules="required|min:8|confirmed:password_confirmation"
                        v-slot="{ errors }"
                      >
                        <input
                          v-model="password"
                          name="password"
                          type="password"
                          class="inputText"
                        />
                        <div class="alert alert-danger" v-show="errors[0]">{{ errors[0] }}</div>
                      </validation-provider>
                    </div>
                  </div>

                  <div class="form-group">
                    <label for="password-confirm" class="label">パスワード再確認</label>

                    <div class="c-valid">
                      <validation-provider
                        name="パスワード再確認"
                        rules="required|min:8"
                        vid="password_confirmation"
                        v-slot="{ errors }"
                      >
                        <input
                          v-model="password_confirmation"
                          name="password_confirmation"
                          type="password"
                          class="inputText"
                        />
                        <div class="alert alert-danger" v-show="errors[0]">{{ errors[0] }}</div>
                      </validation-provider>
                    </div>
                  </div>

                  <div class="form-group">
                      <button type="submit" class="c-btn">登録</button>
                  </div>
                </ValidationObserver>
              </div>
            
          
        </div>
      </div>
    </main>
  </div>
</template>

<script>
import { ValidationProvider, ValidationObserver, extend } from "vee-validate";
import { required, max, min, email, confirmed } from "vee-validate/dist/rules";
extend("required", {
  ...required,
  message: "{_field_}は必須です"
});
extend("email", {
  ...email,
  message: "{_field_}はメールアドレス形式で入力してください"
});
extend("min", {
  ...min,
  message: "{_field_}は最低でも{length}文字入力してくだい"
});
extend("max", {
  ...max,
  message: "{_field_}は最大でも{length}文字までです"
});
extend("confirmed", {
  ...confirmed,
  message: "再確認パスワードと入力が一致していません"
});
export default {
  components: {
    ValidationProvider,
    ValidationObserver
  },
  data() {
    return {
      name: "",
      email: "",
      password: "",
      password_confirmation: "",
      csrf: document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content")
    };
  },
  props: {
    errors: {
      type: Array | Object
    },
     auth: {
      type: Object | Array
    }
  },
  methods: {
    async register() {
      const isValid = await this.$refs.observer.validate(); //触りたい要素にrefを設定すると$refsから取得できる
      if (isValid) { //全てのバリデーション実行後、バリデーションチェックが問題ない場合はtrueが返却され、そうでない場合は、falseが返却される。trueが返却された場合のみ、formをsubmitするように設定
        document.querySelector("#register").submit();
      }
    }
  }
};
</script>

<style scoped>
  .container{
    text-align: center;
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
  .form-group{
    margin: 10px;
  }
  .alert-danger{
    color: red;
  }
</style>