<template>
  <MenuHome tab="clients"/>
  <div class="columns mt-4">
    <div class="column">
      <button class="button is-info ml-6" @click="newClient">Novo cliente</button>
    </div>
    <div class="column">
      <ClientSearchField @search="updateTableSearch"/>
    </div>
  </div>
  <div class="m-6">
    <ClientsTable :search="search"/>
  </div>
</template>

<script>
import MenuHome from "@/components/MenuHome.vue";
import ClientsTable from "@/components/ClientsTable.vue";
import router from "@/router";
import ClientSearchField from "@/components/ClientSearchField.vue";


export default {
  components: {ClientsTable, MenuHome, ClientSearchField},
  name: "ClientsView",
  data(){
    return {
      search: null
    }
  },
  methods:{
    newClient(){
      router.push({ path: '/clients/new' })
    },
    verifySessionIsValid(){
      return !!sessionStorage.getItem('token')
    },
    updateTableSearch(nameSearch){
      this.search = nameSearch
    }
  },
  mounted() {
    if(!this.verifySessionIsValid()){
      router.push({ path: '/' })
    }
  }
}
</script>

<style scoped>
</style>