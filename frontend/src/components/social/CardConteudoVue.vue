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
                <div class="row">
                    <div class="col">
                        <div v-if="totalLikes" class="d-flex py-1 border-bottom">
                            <p class="mb-0 text-muted">
                                <i class="fas fa-sm fa-thumbs-up bg-primary text-white rounded-circle p-1"></i>
                                {{ totalLikes }} curtidas</p>
                        </div>                        
                    </div>
                    <div class="col" v-if="listComments.length">
                        <div  class="d-flex py-1 border-bottom">
                            <p class="mb-0 text-muted">                                
                               {{ listComments.length }} comentários</p>
                        </div>                          
                    </div>
                </div>
                
                

                <div class="d-flex">

				<button @click="like(idContent)" class="btn btn-light flex-fill border-bottom mb-2" :class="{'text-primary': likedThis}">
                    <i class="fa-thumbs-up" :class="{'fas': likedThis, 'far': !likedThis}"></i>
                    <span>Curtir</span>
                    </button>

				<!-- <button @click="jQuery('#inputComment' + idContent).focus()" class="btn btn-light flex-fill"> -->
				<button @click="showComments()" class="btn btn-light flex-fill">
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
                                    :src="user.image"
                                    :alt="user.name"
                                    class="img-fluid rounded-circle"
                                />
                                <!-- notice the "circle" class -->
                            </grid-vue>
                            <grid-vue tamanho="10">
                                <form @submit.prevent="comment(idContent)" >
                                <input @click="showComments()" :id="'inputComment' + idContent" v-model="textComment" type="text" class="form-control bg-muted" placeholder="Escreva um comentário...">
                                </form>
                            </grid-vue>
                        </div>
                        <div>
                            <ul v-if="displayComments" class="list-group">
                                <li class="list-group-item p-0 my-2 border-light" v-for="item in comments" :key="item.id">                                    
                                    <div class="row align-items-center">
                                        <grid-vue tamanho="1">
                                            <img
                                                :src="item.user.image"
                                                :alt="nome"
                                                class="img-fluid rounded-circle"
                                            />
                                        </grid-vue>
                                        <grid-vue tamanho="10">
                                            <div class="bg-grey p-1">                                                
                                                <span class="d-block">
                                                    <strong> {{item.user.name}}</strong>
                                                </span>                                            
                                                <p class="m-0">{{item.text}}</p>
                                            </div>
                                        </grid-vue>
                                    </div>                                    
                                </li>
                                <li class="list-group-item p-0 my-2 border-light ">                                    
                                    <div class="row align-items-center">
                                        <grid-vue tamanho="1">
                                            <img
                                                src="http://127.0.0.1:8000/profiles/profile_id6/1633521061.jpeg"
                                                :alt="nome"
                                                class="img-fluid rounded-circle"
                                            />
                                        </grid-vue>
                                        <grid-vue tamanho="10">
                                            <div class="bg-grey">                                                
                                                <span class="d-block">
                                                    <strong>Teu tio</strong>
                                                </span>                                            
                                                <p>Parabéns</p>
                                            </div>
                                        </grid-vue>
                                    </div>                                    
                                </li>
                            </ul>                             
                            <div  class="d-flex py-1 border-bottom">
                                <a @click="showComments()" class="mb-0 text-muted">                                
                                    Ver mais comementarios</a>
                            </div> 
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
    props: ['idContent', 'perfil', 'nome', 'posted_at', 'totalLikes', 'likedThis', 'contentPostedAt', 'comments'],
    data() {
        return {
            user: false,
            displayComments:  false,
            textComment: '',
            listComments: this.comments || [],
        }
    },
    methods: {
        showComments(){
            this.displayComments = !this.displayComments;
        },
        comment(id){
            if(this.textComment == ''){
                return;
            }
            this.$http
                .put(this.$urlApi+`content/comment/`+ id, {text:this.textComment},
                {
                    headers: {  
                        Authorization: `Bearer ${this.$store.getters.getToken}`,
                    },
                })
                .then(({ data }) => {
                    const responseData = data.data

                    if (data.success){ 
                        this.textComment = '';                       
                        console.log(data);
                        this.$store.commit('setContentsTimeline', responseData.contents.data.data );
                    } else {
                        console.log(data.errors)
                    }

                })
                .catch((e) => {
                    console.log(e);
                });            
        },

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
            this.user = JSON.parse(userAux);
        }
    },
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.bg-grey {
    background: #f0f2f5;
}
</style>
