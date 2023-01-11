<template>
  <MenuHome tab="sales"/>
  <new-sale-form/>
</template>

<script>
import NewSaleForm from "@/components/NewSaleForm.vue";
import MenuHome from "@/components/MenuHome.vue";
export default {
  components:{NewSaleForm, MenuHome},
  name: "NewSaleView"
}
</script>

<style scoped>
</style>