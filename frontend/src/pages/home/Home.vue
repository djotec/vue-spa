<template>
    <site-template>
        <span slot="menuesquerdo">
            <card-menu-vue>
                <div class="row">
                    <grid-vue tamanho="4">
                        <img
                            :src="user.image"
                            :alt="user.name"
                            class="img-fluid rounded-circle"
                        />
                        <!-- notice the "circle" class -->
                    </grid-vue>
                    <grid-vue tamanho="8">
                        <span class="black-text">
                            <h5 class="card-title">{{ user.name }}</h5>
                        </span>
                    </grid-vue>
                </div>
            </card-menu-vue>

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
                :perfil="item.user.image"
                :nome="item.user.name"
                :data="item.user.posted_at"
            >
                <card-post-vue
                    :img="item.image"
                    :txt="item.text"
                    :link="item.link"
                />
            </card-conteudo-vue>
        </span>

        <span slot="menudireito">
            <h3>Contatos</h3>
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
            user: false
        }
    },
    methods: {
        loadUser() {
            let userAux = this.$store.getters.getUser
            if (userAux) {
                this.user = this.$store.getters.getUser
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
                    console.log(data)
                    const responseData = data.data

                    if (data.success) {
                        this.$store.commit('setContentsTimeline', responseData.data )           
                    }
                    console.log(this.contents)
                })
                .catch((e) => {
                    console.log(e)
                })
        },
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
