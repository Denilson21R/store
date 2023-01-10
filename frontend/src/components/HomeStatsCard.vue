<template>
  <div v-bind:class="['column', 'is-half', 'mt-4']">
    <div v-bind:class="['notification', tag, 'has-text-centered']">
      <p><span>{{this.stat}}: <span class="tag is-medium">{{this.statValue}}</span></span></p>
    </div>
  </div>
</template>

<script>
export default {
  name: "HomeStatsCard",
  props: {
    stat: String,
    statValue: String,
    tag: String
  }
}
</script>

<style scoped>

</style>