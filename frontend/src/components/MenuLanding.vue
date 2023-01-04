<template>
  <nav class="navbar m-1" role="navigation" aria-label="main navigation">
    <div class="navbar-brand ml-6">
      <RouterLink to="/">
        <a class="navbar-item">
          Lanchonete
        </a>
      </RouterLink>
    </div>
    <div class="navbar-menu">
      <div class="navbar-start ml-6">
        <RouterLink to="/">
          <a class="navbar-item">
            Sobre
          </a>
        </RouterLink>
      </div>
      <div class="navbar-end">
        <div class="navbar-item">
          <div class="buttons">
            <RouterLink to="/login"><button class="button is-black m-1">Login</button></RouterLink>
            <RouterLink to="/signup"><button class="button is-dark m-1">Cadastro</button></RouterLink>
          </div>
        </div>
      </div>
    </div>
  </nav>
</template>

<script>
export default {
  name: "menu-landing"
}
</script>

<style scoped>

</style>