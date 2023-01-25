<template>
  <MenuHome tab="profile"/>
  <div class="m-6">
    <ProfileForm/>
  </div>
</template>

<script>
import MenuHome from "@/components/MenuHome.vue";
import ProfileForm from "@/components/ProfileForm.vue";
import router from "@/router";

export default {
  components: {MenuHome, ProfileForm},
  name: "ProfileView",
  methods: {
    verifySessionIsValid(){
      return !!sessionStorage.getItem('token')
    }
  },
  mounted() {
    if(!this.verifySessionIsValid()){
      router.push({ path: '/'})
    }
  }
}
</script>

<style scoped>

</style>