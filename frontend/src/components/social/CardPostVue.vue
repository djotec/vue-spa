<template>
<span>
    <div v-if="txt" class="card-content">
         <p> {{txt}} </p>
    </div>
    <div v-if="img" class="card-image">
      <img :src="img" class="card-img-top"  />
    </div>
    
</span>

</template>

<script>

export default {
  name: "CardPostVue",
  props: ["img", "txt"],
  data() {
    return {

    };
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
</style>
