<template>
  <div class="card mb-3" style="width: 18rem;">
    <ul class="list-group list-group-flush">
      <li class="list-group-item">
        <slot />
      </li>
      <li class="list-group-item">
        <slot />
      </li>
      <li class="list-group-item">
        <slot />
      </li>
    </ul>
  </div>
  
</template>

<script>
export default {
  name: "ListContactsVue",
  props: [],
  data() {
    return {};
  },
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
</style>
