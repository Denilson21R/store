<template>
  <MenuHome tab="profile"/>
  <div class="m-6">
    <ProfileForm/>
  </div>
</template>

<script>
import MenuHome from "@/components/MenuHome.vue";
import ProfileForm from "@/components/ProfileForm.vue";
export default {
  components: {MenuHome, ProfileForm},
  name: "ProfileView"
}
</script>

<style scoped>

</style>