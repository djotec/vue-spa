<template>
  <div class="card mb-3" style="width: 18rem">
    <div class="card-body">
      <slot />
    </div>
  </div>
</template>

<script>
export default {
  name: "CardMenuVue",
  props: [],
  data() {
    return {};
  },
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
</style>
