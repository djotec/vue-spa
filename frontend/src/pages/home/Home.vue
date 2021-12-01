<template>
    <site-template>
        <span slot="menuesquerdo">
            <div class="mb-3">
                <div class="d-flex align-items-center">
                        <router-link :to="'/'+user.id+'/'+$slug(user.name)" class="nav-link text-black p-0" >
                        <img
                            :src="user.image"
                            :alt="user.name"
                            class=" rounded-circle me-3"
                            width="48"
                            height="48"
                        />
                        </router-link>
                        <div class="black-text">
                            <router-link :to="'/'+user.id+'/'+$slug(user.name)" class="nav-link text-black p-0" >
                                <span>{{ user.name }}</span>
                            </router-link>
                        </div>
                </div>
            </div>

            <card-menu-vue>
                <div class="row">
                    <h4>Teste</h4>
                </div>
            </card-menu-vue>
            <footer-vue
                cor="green darken-1"
                logo="Social"
                descricao="Teste de descrição"
                ano="2018"
            >
                <li><a class="grey-text text-lighten-3" href="#!">Home</a></li>
                <li>
                    <a class="grey-text text-lighten-3" href="#!">Link 2</a>
                </li>
                <li>
                    <a class="grey-text text-lighten-3" href="#!">Link 3</a>
                </li>
                <li>
                    <a class="grey-text text-lighten-3" href="#!">Link 4</a>
                </li>
            </footer-vue>
        </span>

        <span slot="principal">
            <publicar-conteudo-vue />

            <card-conteudo-vue v-for="item in listContents" :key="item.id" 
                :idContent="item.id"
                :contentPostedAt="item.posted_at"
                :totalLikes="item.total_likes"
                :likedThis="item.i_liked_this"
                :comments="item.comments"
                :userId="item.user.id"
                :perfil="item.user.image"
                :nome="item.user.name"
                :posted_at="item.user.posted_at"
            >
                <card-post-vue
                    :img="item.image"
                    :txt="item.text"
                    :link="item.link"
                />
            </card-conteudo-vue>
            <div v-scroll="handleScroll">
                
            </div>

        </span>

        <span slot="menudireito">
            <h5 class="text-dark border-top">Contatos</h5>
            <ContactList></ContactList>
        </span>
    </site-template>
</template>

<script>
import ContactList from '@/components/ContactList.vue'
import siteTemplate from '@/templates/SiteTemplate'
import CardConteudoVue from '@/components/social/CardConteudoVue'
import CardPostVue from '@/components/social/CardPostVue'
import CardMenuVue from '@/components/layouts/CardMenuVue.vue'
import PublicarConteudoVue from '@/components/social/PublicarConteudoVue'
import GridVue from '@/components/layouts/GridVue.vue'
import FooterVue from '@/components/layouts/FooterVue'

export default {
    name: 'Home',
    components: {
        siteTemplate,
        CardConteudoVue,
        CardPostVue,
        GridVue,
        FooterVue,
        PublicarConteudoVue,
        CardMenuVue,
        ContactList,
    },
    data() {
        return {
            user: {image: '', name: ''},
            urlNextPage: null,
            stopscroll: false,
        }
    },
    methods: {
        handleScroll() {
            // console.log(window.scrollY);
            // console.log(document.body.clientHeight);
            if(this.stopscroll){
                return;
            }
            if (window.scrollY >=  document.body.clientHeight -987) {
                this.stopscroll = true;
                this.loadPagination();
            }
        },
        loadUser() {
            let userAux = this.$store.getters.getUser;
            if (userAux) {
                this.user = this.$store.getters.getUser;
            }
        },

        loadContentList() {
            this.$http
                .get(this.$urlApi + `content/list`, {
                    headers: {
                        Authorization: `Bearer ${this.$store.getters.getToken}`,
                    },
                })
                .then(({ data }) => {
                    const responseData = data.data

                    if (data.success) {
                        this.$store.commit('setContentsTimeline', responseData.data );         
                        this.urlNextPage = responseData.next_page_url;
                        this.stopscroll = false;

                    }
                })
                .catch((e) => {
                    console.log(e)
                })
        },
        loadPagination(){
            if(!this.urlNextPage){
                return;
            }
            this.$http
                .get(this.urlNextPage,{
                    headers: {
                        Authorization: `Bearer ${this.$store.getters.getToken}`,
                    },
                })
                .then(({ data }) => {
                    const responseData = data.data

                    if (data.success && this.$route.name == 'Home') {
                        this.$store.commit('setPaginationContentsTimeline', responseData.data );
                        this.urlNextPage = responseData.next_page_url;                        
                        this.stopscroll = false;
                        console.log('home');
     
                    }
                })
                .catch((e) => {
                    console.log(e)
                })
        }
    },
    created() {
        this.loadUser()
        this.loadContentList()
    },
    computed:{
        listContents(){
            return this.$store.getters.getContentsTimeline;         
        }
    }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
</style>
