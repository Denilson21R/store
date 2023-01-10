<template>
  <div v-bind:class="['column', 'is-half', 'mt-4']">
    <div v-bind:class="['notification', tag, 'has-text-centered']">
      <p><span v-bind:class="[textColor]">{{this.stat}}: {{this.statValue}}</span></p>
    </div>
  </div>
</template>

<script>
export default {
  name: "HomeStatsCard",
  props: {
    stat: String,
    statValue: String,
    tag: String,
    textColor: String,
  }
}
</script>

<style scoped>

</style>