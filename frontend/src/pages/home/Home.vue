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
            <publicar-conteudo-vue :user="user"
                :perfil="user.image"
                :nome="user.name"
                data="31/08/21 08:19"
            />

            <card-conteudo-vue
                :perfil="user.image"
                :nome="user.name"
                data="31/08/21 08:19"
            >
                <card-post-vue
                    img="https://materializecss.com/images/sample-1.jpg"
                    txt="I am a very simple card. I am good at containing small bits of
            information. I am convenient because I require little markup to use
            effectively."
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
import siteTemplate from "@/templates/SiteTemplate";
import CardConteudoVue from "@/components/social/CardConteudoVue";
import CardPostVue from "@/components/social/CardPostVue";
import CardMenuVue from "@/components/layouts/CardMenuVue.vue";
import PublicarConteudoVue from "@/components/social/PublicarConteudoVue";
import GridVue from "@/components/layouts/GridVue.vue";
import FooterVue from "@/components/layouts/FooterVue";

export default {
    name: "Home",
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
        siteTemplate,
        CardConteudoVue,
        CardPostVue,
        GridVue,
        FooterVue,
        PublicarConteudoVue,
        CardMenuVue,
        ContactList
    },
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
</style>
