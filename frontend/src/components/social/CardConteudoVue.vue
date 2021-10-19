<template>
    <div class="card w-100 mb-3" style="width: 18rem">
        <div class="card-body p-0">
            <div class="card-header">
                <div class="row align-items-center">
                    <grid-vue tamanho="1">
                        <img
                            :src="perfil"
                            :alt="nome"
                            class="img-fluid rounded-circle"
                        />
                        <!-- notice the "circle" class -->
                    </grid-vue>
                    <grid-vue tamanho="11">
                        <span class="black-text">
                            <strong>{{ nome }}</strong> -
                            <small>{{ data }}</small>
                        </span>
                    </grid-vue>
                </div>
            </div>
            <div class="card-body">
             <slot></slot>
            </div>

            <div class="card-footer">
                <div class="d-flex">

				<button class="btn btn-light btn-lg flex-fill">
                    <i class="far fa-thumbs-up"></i>
                    <span>Curtir</span>
                    </button>

				<button class="btn btn-light btn-lg flex-fill">
                    <i class="far fa-comment"></i>
                    <span>Comentar</span>
                    </button>

				<button class="btn btn-light btn-lg flex-fill">
                    <i class="far fa-share-square"></i>
                    <span>compartilhar</span>
                    </button>
                </div>
                
            </div>
        </div>
    </div>
</template>

<script>
import GridVue from "@/components/layouts/GridVue";

export default {
    name: "CardConteudoVue",
    props: ["perfil", "nome", "data"],
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
    components: {
        GridVue,
    },
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
</style>
