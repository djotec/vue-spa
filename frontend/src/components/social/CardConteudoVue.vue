<template>
    <div class="card shadow-sm w-100 mb-3" style="width: 18rem">
        <div class="card-body p-0">
            <div class="card-header border-0">
                <div class="row align-items-center">
                    <grid-vue tamanho="1">
                        <img
                            :src="perfil"
                            :alt="nome"
                            class="img-fluid rounded-circle"
                        />
                        <!-- notice the "circle" class -->
                    </grid-vue>
                    <grid-vue tamanho="10">
                        <span class="black-text">
                            <strong>{{ nome }}</strong>
                            <small>{{ data }}</small>
                        </span>
                    </grid-vue>
                    <grid-vue tamanho="1">
                        <button @click="deleteContent()" type="button" class="btn btn-light" >
                        <i class="fas fa-trash"></i>
                        </button>                       
                    </grid-vue>
                </div>
            </div>
            <div class="card-body p-0">
             <slot></slot>
            </div>

            <div class="card-footer">
                <div class="d-flex">

				<button class="btn btn-light flex-fill">
                    <i class="far fa-thumbs-up"></i>
                    <span>Curtir</span>
                    </button>

				<button class="btn btn-light flex-fill">
                    <i class="far fa-comment"></i>
                    <span>Comentar</span>
                    </button>

				<button class="btn btn-light flex-fill">
                    <i class="far fa-share-square"></i>
                    <span>Compartilhar</span>
                    </button>
                </div>
                
            </div>
        </div>
    </div>
</template>

<script>
import GridVue from '@/components/layouts/GridVue'

export default {
    name: 'CardConteudoVue',
    components: {
        GridVue,
    },
    props: ['perfil', 'nome', 'data'],
    data() {
        return {
            user: false,
            curtiu: 'far',
        }
    },
    methods: {
        deleteContent() {
            this.$http
                .get(this.$urlApi + `content/delete`, {
                    headers: {
                        Authorization: `Bearer ${this.$store.getters.getToken}`,
                    },
                })
                .then(({ data }) => {
                    console.log(data)
                    const responseData = data.data

                    
                })
                .catch((e) => {
                    console.log(e)
                })
            console.log();
        }
    },
    created() {
        let userAux = sessionStorage.getItem('user')
        if (userAux) {
            this.user = JSON.parse(userAux)
        }
    },
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
</style>
