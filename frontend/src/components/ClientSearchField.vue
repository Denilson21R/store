<template>
  <div class="columns ml-6">
    <div class="column">
      <input class="input" type="text" placeholder="Nome do cliente" v-model="searchName">
    </div>
    <div class="column">
      <button class="button is-dark" @click="search" type="submit">Buscar</button>
    </div>
  </div>
</template>

<script>
export default {
  name: "ClientSearchField",
  data(){
    return{
      searchName:""
    }
  },
  methods:{
    search(){
      this.$emit('search', this.searchName)
    }
  }
}
</script>

<style scoped>

</style>