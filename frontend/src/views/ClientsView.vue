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
export default {
  components: {ClientsTable, MenuHome},
  name: "ClientsView",
  methods:{
    newClient(){
      //TODO: open new client view
      //router.push({ path: '/client/new' })
    }
  }
}
</script>

<style scoped>

</style>