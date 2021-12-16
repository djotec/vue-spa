<template>
    <span>
        <header class="mb-3">
            <nav-bar logo="facebook" url="#" cor="green darken-1">
                <li class="nav-item"> 
                    <router-link to="/" class="nav-link active" >Página Inicial</router-link>
                </li>
                <li v-if="user" class="nav-item"> 
                    <router-link to="/settings" class="nav-link" >{{ user.name }}</router-link>
                </li>
                <li v-if="user" class="nav-item"> 
                    <a v-on:click="sair()" class="nav-link">Sair</a>
                </li>
            </nav-bar>
        </header>

        <main>
            <div class="container-fluid">
                <div class="row justify-content-between">
                    <grid-vue tamanho="sm-2">
                        <slot name="menuesquerdo" />
                    </grid-vue>

                    <grid-vue tamanho="sm-5">
                        <slot name="principal" />
                    </grid-vue>
                    <grid-vue tamanho="sm-2">
                        <slot name="menudireito" />
                    </grid-vue>
                </div>
            </div>
        </main>
    </span>
</template>

<script>
import NavBar from "@/components/layouts/NavBar";
import GridVue from "@/components/layouts/GridVue";

export default {
    name: "SiteTemplate",
    data() {
        return {
            user: false,
        };
    },
    components: {
        NavBar,
        GridVue,
    },    
    methods: {
        sair() {            
            this.$store.commit('setUser', null),
            sessionStorage.clear();
            this.user = false;
            this.$router.push('/login')
        },       
    },
    created() {
        console.log("created()");
        let userAux = this.$store.getters.getUser;
        if (userAux) {
            this.user = this.$store.getters.getUser;
        } else {
            this.$router.push("/login");
        }
    },

};
</script>

<style>
</style>
