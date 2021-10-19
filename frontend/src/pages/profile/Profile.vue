<template>
    <site-template>
        <span slot="menuesquerdo">
            <div class="row align-items-center">
                <grid-vue tamanho="3">
                    <img
                        :src="user.image"
                        :alt="user.name"
                        class="img-fluid rounded-circle"
                    />
                </grid-vue>

                <grid-vue tamanho="9">
                    <div>
                        <p class="h1">Perfil</p>
                    </div>
                </grid-vue>
            </div>
        </span>

        <span slot="principal">
            <p class="h4">Configurações gerais da conta</p>
            <hr />
            <div class="mb-4">
                <div class="card-body">
                    <form @submit.prevent="update()">
                        <div class="form-row">
                            <div class="input-group col-md-12 mb-3">
                                <input
                                    type="text"
                                    class="form-control form-control"
                                    placeholder="Nome"
                                    v-model="name"
                                />
                            </div>
                            <div class="form-group col-md-12 mb-3">
                                <input
                                    type="email"
                                    class="form-control form-control"
                                    placeholder="Email"
                                    v-model="email"
                                />
                            </div>
                            <div class="form-group col-md-12 mb-3">
                                <input
                                    class="form-control"
                                    type="file" 
                                    v-on:change="saveImage"                                   
                                />
                            </div>
                            <div class="form-group col-md-12 mb-3">
                                <input
                                    type="password"
                                    class="form-control form-control"
                                    placeholder="Senha"
                                    v-model="password"
                                />
                            </div>
                            <div class="form-group col-md-12 mb-3">
                                <input
                                    type="password"
                                    class="form-control form-control"
                                    placeholder="Confirme sua senha"
                                    v-model="password_confirmation"
                                />
                            </div>

                            <div class="d-grid gap-2 mb-3">
                                <button type="submit" class="btn btn-primary">
                                    Atualizar
                                </button>
                            </div>

                            <div v-if="Array.isArray(messages) && messages.length > 0" class="alert alert-success" >
                                 <ul class="list-unstyled">
                                    <li
                                        v-for="(msg, index) in messages"
                                        :key="index"
                                    >
                                        {{ msg }}
                                    </li>
                                </ul>
                            </div>

                            <div class="d-grid gap-2 mb-3" v-if="erros">
                                <ul class="list-unstyled">
                                    <li
                                        v-for="(erro, index) in erros"
                                        :key="index"
                                        class="text-center text-danger"
                                    >
                                        {{ erro[0] }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </span>
    </site-template>
</template>

<script>
import SiteTemplate from "@/templates/SiteTemplate";
import GridVue from "@/components/layouts/GridVue";

export default {
    name: "Profile",
    data() {
        return {
            showSignupForm: false,
            user: false,
            name: "",
            email: "",
            password: "",
            password_confirmation: "",
            image: "",
            erros: [],
            messages: []
        };
    },
    components: {
        SiteTemplate,
        GridVue,
    },
    created() {
        let userAux = sessionStorage.getItem("user");
        if (userAux) {
            this.user = JSON.parse(userAux);
            this.name = this.user.name;
            this.email = this.user.email;
        }
    },
    methods: {
        saveImage(e){
            let arquivo = e.target.files || e.dataTransfer.files;
            if (!arquivo.length){
                console.log('aqui');
                return;
            }

            let reader = new FileReader();
            reader.onloadend = (e) => {
                this.image =  e.target.result;
            }            
            reader.readAsDataURL(arquivo[0]);

            setTimeout(() => {
            }, 500)


        },
        /**
         * Atualiza os dados do perfil
         */
        update() {
            this.messages = [];
            this.erros = [];                        
            this.$http
                .put(
                    this.$urlApi+`profile`,
                    {
                        name: this.name,
                        email: this.email,
                        image: this.image,
                        password: this.password,
                        password_confirmation: this.password_confirmation,
                    },
                    {
                        headers: {  
                            Authorization: `Bearer ${this.user.token}`,
                        },
                    }
                )
                .then(({ data }) => {
                    if (data.success) {
                        //Login com sucesso
                        console.log(data);
                        this.user = data.data;
                        sessionStorage.setItem("user", JSON.stringify(this.user));
                        this.messages.push(data.message)
                    } else {
                        //erros de validação
                        this.erros = Object.values(data.errors);
                    }
                })
                .catch((e) => {
                    console.log(e);
                    this.erros = [{ 0: "Erro! Tente novamente mais tarde" }];                    
                });
        },        
    },
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
body {
    background: #fff;
}
</style>
