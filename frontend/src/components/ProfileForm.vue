<template>
  <form class="is-justify-content-center m-6" @submit.prevent="saveProfile">
    <div class="field">
      <label class="label">Nome</label>
      <input type="text" v-bind:class="{'input': true, 'is-success':nameValid, 'is-danger':!nameValid}" v-model="name">
    </div>
    <div class="field">
      <label class="label">Login</label>
      <input type="text" v-bind:class="{'input': true, 'is-success':loginValid, 'is-danger':!loginValid}" v-model="login">
    </div>
    <div class="field">
      <label class="label">Nova Senha</label>
      <input type="password" v-bind:class="{'input': true, 'is-success':passwordValid, 'is-danger':!passwordValid && password != null}" v-model="password">
    </div>
    <div class="field">
      <label class="label">Repita a senha</label>
      <input type="password" v-bind:class="{'input': true, 'is-success':repeatPasswordValid, 'is-danger':!repeatPasswordValid && repeatPassword != null}" v-model="repeatPassword">
    </div>
    <div class="field is-grouped">
      <div class="control">
        <button class="button is-link">Salvar</button>
      </div>
    </div>
  </form>
</template>

<script>
import * as bulmaToast from "bulma-toast";
import axios from 'axios'
import router from "@/router";

export default {
  name: "ProfileForm",
  data(){
    return{
      id: sessionStorage.getItem('id'),
      login: sessionStorage.getItem('login'),
      name: sessionStorage.getItem('name'),
      token: sessionStorage.getItem('token'),
      password: null,
      repeatPassword: null,
    }
  },
  methods: {
    saveProfile(){
      if(this.nameValid && this.loginValid && this.passwordValid && this.repeatPasswordValid && this.verifySessionIsValid()){
        this.requestUpdateUserData()
      }else if(!this.verifySessionIsValid()){
        router.push({ path: '/' })
      }else{
        this.toast("Preencha os campos corretamente!", "is-danger")
      }
    },
    requestUpdateUserData(){
      axios.put("http://localhost:8000/api/user/"+this.id, {
        name: this.name,
        login: this.login,
        password: this.password
      }).then((response)=>{
        if(response.status === 200){
          this.updateUserDataSession()
          this.resetForm()
          this.toast("Usuário atualizado com sucesso!", "is-success")
        }else{
          this.toast("Ocorreu um erro ao atualizar o usuário!", "is-danger")
        }
      })
    },
    resetForm(){
      this.password = null
      this.repeatPassword = null
    },
    updateUserDataSession(){
      sessionStorage.setItem('login', this.login)
      sessionStorage.setItem('name', this.name)
    },
    verifySessionIsValid(){
      return !!sessionStorage.getItem('token');
    },
    toast(message, type){
      bulmaToast.toast({
        message: message,
        type: type,
        dismissible: true
      })
    }
  },
  computed: {
    nameValid(){
      return !!(this.name && this.name.length >= 3)
    },
    loginValid(){
      return !!(this.login && this.login.length >= 6)
    },
    passwordValid(){
      return !!(this.password && this.password.length >= 6)
    },
    repeatPasswordValid(){
      return !!(this.repeatPassword && this.repeatPassword.length >= 6 && this.repeatPassword === this.password)
    }
  }
}
</script>

<style scoped>
</style>