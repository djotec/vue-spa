<template>
  <div class="contact-list__item">
      <div class="d-flex align-items-center">
          <img
                :src="friendImage"
                :alt="friendName"
                class="img-fluid rounded-circle contact-list__photo"
            />

            <span>{{friendName}}</span>
      </div>
  </div>
</template>

<script>
export default {
    props: ['friendImage', 'friendName'],
    data() {
        return {
            user: false
        };
    },
    created() {
        let userAux = sessionStorage.getItem("user");
        if (userAux) {
            this.user = JSON.parse(userAux);
        }
    },

}
</script>

<style>
.contact-list__photo{
    width: 36px;
    height: 36px;
    margin-right: 8px;
}
.contact-list__item{
    border-radius: 8px;
    margin-bottom: 8px;
    padding: 4px;
}
.contact-list__item:hover{
    background: rgba(0,0,0,.08);
}
</style>