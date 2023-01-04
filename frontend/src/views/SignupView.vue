<template>
  <MenuLanding></MenuLanding>
  <div class="container m-6 form-login">
    <h1 class="title">Cadastrar-se</h1>
    <form @submit.prevent="submitSignUp">
      <div class="field">
        <label class="label">Nome</label>
        <div class="control">
          <input type="text" v-bind:class="{'input': true, 'is-success': name && name.length >= 3}" v-model="name">
        </div>
      </div>
      <div class="field">
        <label class="label">Login</label>
        <div class="control">
          <input type="text" v-bind:class="{'input': true, 'is-success': login && login.length >= 6}" v-model="login">
        </div>
      </div>
      <div class="field">
        <label class="label">Senha</label>
        <div class="control">
          <input type="password" v-bind:class="{'input': true, 'is-success': password && password.length >= 6}" v-model="password">
        </div>
      </div>
      <div class="field">
        <label class="label">Repita sua senha</label>
        <div class="control">
          <input type="password" v-bind:class="{'input': true, 'is-success': repeat_password && repeat_password.length >= 6 && repeat_password === password}" v-model="repeat_password">
        </div>
      </div>
      <div class="field is-grouped">
        <div class="control">
          <button type="submit" class="button is-link">Cadastrar</button>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
import axios from 'axios'
import * as bulmaToast from "bulma-toast";
import MenuLanding from "@/components/Menu.vue";

export default {
  components: {MenuLanding},
  data() {
    return {
      name: null,
      login: null,
      password: null,
      repeat_password: null,
    }
  },
  methods: {
    submitSignUp(){
      if(this.password === this.repeat_password){
        signupRequest.call(this);
      }else{
        bulmaToast.toast({
          message: "Senhas são diferentes!",
          type: 'is-danger',
          dismissible: true
        })
      }
    }
  }
}

function signupRequest() {
  axios.post('http://localhost:8000/api/user',
      {
        name: this.name,
        login: this.login,
        password: this.password
      }).then((response) => {
    if (response.status === 201) {
      bulmaToast.toast({
        message: "Usuário salvo com sucesso!",
        type: 'is-success',
        dismissible: true
      })
      resetForm.call(this);
    } else {
      bulmaToast.toast({
        message: "Ocorreu um erro durante o cadastro!",
        type: 'is-danger',
        dismissible: true
      })
    }
  })
}

function resetForm() {
  this.name = null
  this.login = null
  this.password = null
  this.repeat_password = null
}
</script>

<style scoped>
</style>
