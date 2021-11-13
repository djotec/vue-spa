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
                        <span class="d-block">
                            <strong>{{ nome }}</strong>
                        </span>
                        <span class="mb-0 text-muted">
                            <small>{{ contentPostedAt }}</small>
                        </span>
                    </grid-vue>

                    <grid-vue tamanho="1">
                        <div class="btn-group">
                            <button type="button" class="btn btn-light" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-h"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#"  @click="deleteContent(idContent)"><i class="fas fa-trash me-2"></i> Excluir</a></li>
                            </ul>
                         </div>
                    </grid-vue>
                </div>
            </div>
            <div class="card-body p-0">
             <slot></slot>
            </div>

            <div class="card-footer">
                
                <div v-if="totalLikes" class="d-flex py-1 border-bottom">
                    <p class="mb-0 text-muted">
                        <i class="fas fa-sm fa-thumbs-up bg-primary text-white rounded-circle p-1"></i>
                        {{ totalLikes }} curtidas</p>
                </div>

                <div class="d-flex">

				<button @click="like(idContent)" class="btn btn-light flex-fill border-bottom mb-2" :class="{'text-primary': likedThis}">
                    <i class="fa-thumbs-up" :class="{'fas': likedThis, 'far': !likedThis}"></i>
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
                <div>
                    <div class="mb-3">
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
                                <textarea class="form-control bg-muted" id="commentFormControl" placeholder="Escreva um comentário..." rows="1"></textarea>
                            </grid-vue>
                        </div>
                        <div>
                            <ul class="list-group">
                                <li class="list-group-item">                                    
                                    <div class="row align-items-center">
                                        <grid-vue tamanho="1">
                                            <img
                                                :src="perfil"
                                                :alt="nome"
                                                class="img-fluid rounded-circle"
                                            />
                                        </grid-vue>
                                        <grid-vue tamanho="10">
                                            <span class="d-block">
                                                <strong>Teu tio</strong>
                                            </span>                                            
                                            <p>Parabéns</p>
                                        </grid-vue>
                                    </div>                                    
                                </li>
                                <li class="list-group-item">
                                    
                                </li>
                                </ul>                        
                        </div>

                    </div>
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
    props: ['idContent', 'perfil', 'nome', 'data', 'totalLikes', 'likedThis', 'contentPostedAt'],
    data() {
        return {
            user: false,
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
                    const responseData = data.data

                    if (data.success){                        
                        console.log(data);
                        this.totalLike = responseData.total_likes; 
                        this.$store.commit('setContentsTimeline', responseData.contents.data.data );
                    } else {
                        console.log(data.errors)
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
