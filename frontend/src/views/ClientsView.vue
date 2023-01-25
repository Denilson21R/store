<template>
  <MenuHome tab="clients"/>
  <button class="button is-info ml-6" @click="newClient">Novo cliente</button>
  <div class="m-6">
    <ClientsTable/>
  </div>
</template>

<script>
import MenuHome from "@/components/MenuHome.vue";
import ClientsTable from "@/components/ClientsTable.vue";
import router from "@/router";

export default {
  components: {ClientsTable, MenuHome},
  name: "ClientsView",
  methods:{
    newClient(){
      router.push({ path: '/clients/new' })
    },
    verifySessionIsValid(){
      return !!sessionStorage.getItem('token')
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