<template>
  <div>
    <main>
      <div class="container" v-if="auth.length === 0">
            <div class="panel panel-default">
              <div class="panel-heading text-center">ログイン</div>
              <div class="form-group has-error" v-if="errors.length !== 0">
                <div class="alert alert-danger text-center">
                  ログイン時にエラーが発生しました
                  <div v-for="(error, key, index) in errors" :key="index">{{error}}</div>
                </div>
              </div>
              <div class="panel-body">
                <ValidationObserver
                  class="form-horizontal"
                  ref="observer"
                  action="/login"
                  id="login"
                  method="post"
                  @submit.prevent="login()"
                  tag="form"
                  v-slot="{ invalid }"
                >
                  <input type="hidden" name="_token" :value="csrf" />

                  <div class="form-group">
                    <p><label for="email" class="col-md-4 control-label">メールアドレス</label></p>
                      <validation-provider
                        name="メールアドレス"
                        rules="required|email"
                        v-slot="{ errors }"
                      >
                        <input v-model="email" name="email" type="email" class="inputText" />
                        <div class="alert alert-danger" v-show="errors[0]">{{ errors[0] }}</div>
                      </validation-provider>
                  </div>

                  <div class="form-group">
                    <p><label for="password" class="col-md-4 control-label">パスワード</label></p>
                      <validation-provider name="パスワード" rules="required" v-slot="{ errors }">
                        <input
                          v-model="password"
                          name="password"
                          type="password"
                          class="inputText"
                        />
                        <div class="alert alert-danger" v-show="errors[0]">{{ errors[0] }}</div>
                      </validation-provider>
                  </div>

                  <div class="form-group">
                        <label>
                          <input type="checkbox" name="remember" /> ログインを継続する
                        </label>
                  </div>

                  <div class="form-group">
                      <button type="submit" class="c-btn btn-primary">ログイン</button>

                      <!-- <a class="btn btn-link" href>パスワードをお忘れですか?</a> -->
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
import { required, email } from "vee-validate/dist/rules";
extend("required", {
  ...required,
  message: "{_field_}は必須です"
});
extend("email", {
  ...email,
  message: "{_field_}はメールアドレス形式で入力してください"
});
export default {
  components: {
    ValidationProvider,
    ValidationObserver
  },
  data() {
    return {
      email: "",
      password: "",
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
    async login() {
      const isValid = await this.$refs.observer.validate();
      if (isValid) {
        document.querySelector("#login").submit();
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
</style>