<template>
  <MenuHome tab="products"/>
  <update-product-form />
</template>

<script>
import MenuHome from "@/components/MenuHome.vue";
import UpdateProductForm from "@/components/UpdateProductForm.vue";

export default {
  components: {MenuHome, UpdateProductForm},
  name: "UpdateProductView"
}
</script>

<style scoped>

</style>