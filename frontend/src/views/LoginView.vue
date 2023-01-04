<template>
  <MenuLanding/>
  <div class="container m-6 form-login">
    <h1 class="title">Login</h1>
    <form @submit.prevent="submitLogin">
      <div class="field">
        <label class="label">Login</label>
        <div class="control">
          <input type="text" v-bind:class="{'input': true, 'is-success': login && login.length >= 3}" v-model="login">
        </div>
      </div>
      <div class="field">
        <label class="label">Senha</label>
        <div class="control">
          <input type="password" v-bind:class="{'input': true, 'is-success': password && password.length >= 3}" v-model="password">
        </div>
      </div>
      <div class="field is-grouped">
        <div class="control">
          <button type="submit" class="button is-link">Login</button>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
import axios from 'axios'
import router from "@/router";
import * as bulmaToast from 'bulma-toast'
import MenuLanding from "@/components/MenuLanding.vue";

export default {
  components: {MenuLanding},
  data() {
    return {
      login: null,
      password: null
    }
  },
  methods: {
    submitLogin(){
      if(this.login.length >= 6 && this.password.length >= 6){
        loginRequest.call(this);
      }else{
        bulmaToast.toast({
          message: "Login e senha devem ter no mínimo 6 caracteres!",
          type: 'is-danger',
          dismissible: true
        })
      }
    }
  }
}

function loginRequest() {
  axios.post('http://localhost:8000/api/user/auth',
  {
    login: this.login,
    password: this.password
  }).then((response)=>{
    if (response.status === 200){
      saveSession.call(this, response);
      router.push({ path: '/home' })
    }else{
      bulmaToast.toast({
        message: "Ocorreu um erro durante o login!",
        type: 'is-danger',
        dismissible: true
      })
    }
  })
}

function saveSession(response) {
  sessionStorage.setItem('token', response.data.api_key)
  sessionStorage.setItem('id', response.data.id)
  sessionStorage.setItem('login', this.login)
}
</script>

<style scoped>
</style>