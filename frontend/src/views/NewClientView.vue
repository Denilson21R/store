<template>
  <MenuHome tab="clients"/>
  <NewClientForm/>
</template>

<script>
import MenuHome from "@/components/MenuHome.vue";
import NewClientForm from "@/components/NewClientForm.vue";
export default {
  components: {NewClientForm, MenuHome},
  name: "NewClientView"
}
</script>

<style scoped>

</style>