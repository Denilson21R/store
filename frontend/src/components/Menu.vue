<template>
  <nav class="navbar" role="navigation" aria-label="main navigation">
    <div class="navbar-brand ml-6">
      <a class="navbar-item">
        Lanchonete
      </a>
    </div>
    <div id="navbarBasicExample" class="navbar-menu">
      <div class="navbar-start ml-6">
        <a class="navbar-item is-hoverable">
          Início
        </a>
        <div class="navbar-item has-dropdown is-hoverable ml-6">
          <a class="navbar-link">
            More
          </a>
          <div class="navbar-dropdown">
            <a class="navbar-item">
              About
            </a>
          </div>
        </div>
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