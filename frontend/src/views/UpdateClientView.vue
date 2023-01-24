<template>
  <MenuHome tab="clients"/>
  <UpdateClientForm/>
</template>

<script>
import MenuHome from "@/components/MenuHome.vue";
import UpdateClientForm from "@/components/UpdateClientForm.vue";
export default {
  components: {MenuHome, UpdateClientForm},
  name: "UpdateClientView"
}
</script>

<style scoped>

</style>