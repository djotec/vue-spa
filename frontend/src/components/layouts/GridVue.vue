<template>
  <div :class="tamanho ? 'col-'+ tamanho : 'col'">
    <slot></slot>
  </div>
</template>

<script>
export default {
  name: 'GridVue',
  props:['tamanho'],
  data () {
    return {

    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
