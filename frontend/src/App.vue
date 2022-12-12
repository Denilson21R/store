<script setup lang="ts">
import { RouterLink, RouterView } from 'vue-router'
</script>
<template>
  <header>
    <div class="wrapper">
      <nav>
        <RouterLink to="/login"><button class="button is-link m-1">Login</button></RouterLink>
        <RouterLink to="/sigin"><button class="button is-link m-1">Cadastro</button></RouterLink>
      </nav>
    </div>
  </header>
  <RouterView />
</template>
<style scoped>
</style>
