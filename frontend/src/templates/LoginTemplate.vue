<template>
    <span>
        <main>
            <section class="login-section">
                <div class="container">
                    <div class="row justify-content-center">
                        <grid-vue tamanho="md-10">
                            <div class="row">
                                <grid-vue tamanho="md-7 p-5">
                                    <slot name="asside-left" />
                                </grid-vue>

                                <grid-vue tamanho="md-5 px-4">
                                    <slot name="principal" />
                                </grid-vue>
                            </div>
                        </grid-vue>
                    </div>
                </div>
            </section>
        </main>

        <footer class="mt-5">
            <section class="bg-white">
                <div class="container">
                    <div class="row pt-3 pb-5">
                        <div class="col-12">
                            <ul class="list-unstyled list-inline small">
                                <li class="list-inline-item">
                                    Português (Brasil)
                                </li>
                                <li class="list-inline-item">English (US)</li>
                                <li class="list-inline-item">Español</li>
                                <li class="list-inline-item">
                                    Français (France)
                                </li>
                                <li class="list-inline-item">Italiano</li>
                            </ul>
                            <hr />
                            <small
                                >Facebook &copy; {{ new Date().getFullYear() }}
                            </small>
                        </div>
                    </div>
                </div>
            </section>
        </footer>
    </span>
</template>

<script>
import NavBar from "@/components/layouts/NavBar";
import GridVue from "@/components/layouts/GridVue";

export default {
    name: "siteTemplate",
    data() {
        return {
            user: false,
        };
    },
    components: {
        NavBar,
        GridVue,
    },

    created() {
        console.log("created()");
        let userAux = sessionStorage.getItem("user");
        if (userAux) {
            this.user = JSON.parse(userAux);
            this.$router.push("/");
        }
    },
    methods: {
        sair() {
            sessionStorage.clear();
            this.user = false;
        },       
    }

};
</script>

<style scoped>
.login-section {
    padding: 112px 0;
}
</style>
