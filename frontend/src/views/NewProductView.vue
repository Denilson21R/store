<template>
  <MenuHome tab="products"/>
  <NewProductForm/>
</template>

<script>
import MenuHome from "@/components/MenuHome.vue";
import NewProductForm from "@/components/NewProductForm.vue";

export default {
  components: {MenuHome, NewProductForm},
  name: "NewProductView"
}
</script>

<style scoped>

</style>