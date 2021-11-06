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
                        <button @click="deleteContent(idContent)" type="button" class="btn btn-light" >
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

				<button @click="like(idContent)" class="btn btn-light flex-fill">
                    <i :class="liked"></i>
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
                <div v-if="totalLike" class="d-flex">
                    <p>curtido por {{ totalLike }} pessoa</p>
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
    props: ['idContent', 'perfil', 'nome', 'data'],
    data() {
        return {
            user: false,
            liked: 'far fa-thumbs-up',
            totalLike: 0,
        }
    },
    methods: {
        like(id){
            
            this.$http
                .put(this.$urlApi+`content/like/`+ id, {},
                {
                    headers: {  
                        Authorization: `Bearer ${this.$store.getters.getToken}`,
                    },
                })
                .then(({ data }) => {
                    if (data.success){                        
                        console.log(data); 
                        this.totalLike = data.data; 
                        if(this.liked == 'far fa-thumbs-up'){
                            this.liked = 'fas fa-thumbs-up';
                        } else{
                            this.liked = 'far fa-thumbs-up';
                        }
                    } else {
                        console.log(data.success.errors)
                    }


                })
                .catch((e) => {
                    console.log(e);

                });

            
        },
        deleteContent(id) {
            this.$http
                .put(this.$urlApi + `content/delete/`+id,{},
                {
                    headers: {
                        Authorization: `Bearer ${this.$store.getters.getToken}`,
                    },
                })
                .then(({ data }) => {
                    
                    if (data.success) {
                        console.log(data)                        
                    }             
                })
                .catch((e) => {
                    console.log(e)
                });
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
