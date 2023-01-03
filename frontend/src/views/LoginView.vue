<template>
  <div class="container mt-5 form-login">
    <h1 class="title">Login</h1>
    <form @submit.prevent="submitLogin">
      <div class="field">
        <label class="label">Login</label>
        <div class="control">
          <input type="text" class="input" v-model="login">
        </div>
      </div>
      <div class="field">
        <label class="label">Senha</label>
        <div class="control">
          <input type="password" class="input" v-model="password">
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

  export default {
    data() {
      return {
        login: "",
        password: ""
      }
    },
    methods: {
      submitLogin(){
        loginRequest.call(this);
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
        console.log(response.data)
      }else{
        alert("erro")
      }
    })
  }
</script>

<style scoped>
</style>