<template>
    <login-template>
        <span slot="asside-left">
            <h1 class="hero-title fw-bold text-primary">facebook</h1>
            <p class="h3">
                O Facebook ajuda você a se conectar e compartilhar com as
                pessoas que fazem parte da sua vida.
            </p>
        </span>

        <span slot="principal">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <form v-if="!showSignupForm" @submit.prevent="login()">
                        <div class="form-row">
                            <div class="form-group col-md-12 mb-3">
                                <input type="email" class="form-control form-control-lg" placeholder="Email" v-model="email"  :disabled="isLoading"/>
                            </div>
                            <div class="form-group col-md-12 mb-3">
                                <input type="password" class="form-control form-control-lg"  placeholder="Senha" v-model="password" :disabled="isLoading"/>
                            </div>

                            <div class="d-grid gap-2 mb-3">
                                <button type="submit" class="btn btn-lg btn-primary" :disabled="isLoading">Entrar</button>
                            </div>
                            <hr class="my-4" />
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
                                    <li v-for="(erro, index) in erros" :key="index" class="text-center text-danger" >
                                        {{ erro[0] }}
                                    </li>
                                </ul>
                            </div>
                            <div class="text-center">
                                <button class="btn btn-lg btn-success" type="button" v-on:click="showSignupForm = !showSignupForm"  >  Criar nova conta </button>
                            </div>
                        </div>
                    </form>
                    <form v-if="showSignupForm" @submit.prevent="cadastrar()">
                        <div class="form-row">
                            <div class="form-group col-md-12 mb-3">
                                <input
                                    type="text"
                                    class="form-control form-control-lg"
                                    placeholder="Nome"
                                    v-model="name" 
                                />
                            </div>
                            <div class="form-group col-md-12 mb-3">
                                <input
                                    type="email"
                                    class="form-control form-control-lg"
                                    placeholder="Email"
                                    v-model="email" 
                                />
                            </div>
                            <div class="form-group col-md-12 mb-3">
                                <input
                                    type="password"
                                    class="form-control form-control-lg"
                                    placeholder="Senha"
                                    v-model="password" 
                                />
                            </div>
                            <div class="form-group col-md-12 mb-3">
                                <input
                                    type="password"
                                    class="form-control form-control-lg"
                                    placeholder="Confirme sua senha"
                                    v-model="password_confirmation" 
                                />
                            </div>

                            <div class="d-grid gap-2 mb-3">
                                <button type="submit" class="btn btn-lg btn-primary"> Enviar </button>                                
                            </div>
                            <div class="d-grid gap-2 mb-3" v-if="erros">
                                <ul class="list-unstyled">
                                    <li v-for="(erro, index) in erros" :key="index" class="text-center text-danger" >
                                        {{ erro[0] }}
                                    </li>
                                </ul>
                            </div>
                            <div class="d-grid gap-2 col-8 mx-auto">
                                <button class="btn btn-lg btn-success" type="button" v-on:click="showSignupForm = !showSignupForm">
                                    Já tenho uma conta
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <p class="text-center">
                <strong>Criar uma Página</strong> para uma celebridade, banda ou
                empresa.
            </p>
        </span>
    </login-template>
</template>

<script>
import LoginTemplate from "@/templates/LoginTemplate";

export default {
    name: "Login",
    data() {
        return {
            isLoading: false,
            showSignupForm: false,
            name: "",
            email: "",
            password: "",
            password_confirmation: "",
            erros: [],
            messages: []
        };
    },
    components: {
        LoginTemplate,
    },
    methods: {
        login: function () {
            this.isLoading = true;
            this.erros = []
            this.$http
                .post(this.$urlApi+`login`, {
                    email: this.email,
                    password: this.password,
                })
                .then(({ data }) => {
                 console.log(data);
                 this.isLoading = false;
                    if (data.success) {
                        //Login com sucesso
                        console.log("Login com sucesso");
                        sessionStorage.setItem("user", JSON.stringify(data.data));
                        this.$router.push("/");                        

                    } else if (data.success == false && data.errors) {
                        this.isLoading = false;
                        //erros de validação
                        console.log("erros de validação");
                        this.erros = Object.values(data.errors); 
                    
                    } else {
                        //login não exite
                        console.log("login não exite");
                        this.erros = Object.values(data.errors); 
                    }
                })
                .catch((e) => {
                    this.isLoading = false;
                    console.log(e);
                    this.erros = [{ 0: "Erro! Tente novamente mais tarde" }];
                });
        },
        cadastrar: function () {
            this.erros = []
            this.isLoading = true;
            this.$http
                .post(this.$urlApi+`cadastro`, {
                    name: this.name,
                    email: this.email,
                    password: this.password,
                    password_confirmation: this.password_confirmation,
                })
                .then(({ data }) => {
                    this.isLoading = false; 

                    console.log(data);
                    if (data.success) {
                        //Cadastro realizado com sucesso
                        console.log("Cadastro realizado  com sucesso");
                        sessionStorage.setItem("user", JSON.stringify(data.data));                       
                        this.$router.push("/");

                    } else if (data.success == false && data.errors) {                        
                        this.isLoading = false;
                        //erros de validação
                        console.log("erros de validação");
                        this.erros = Object.values(data.errors);    

                    } else {
                        //login não exite
                        this.erros = [
                            { 0: "Erro no cadastro! Tente novamente mais tarde." },
                        ];
                    }
                })
                .catch((e) => {
                    console.log(e);
                    this.erros = [{ 0: "Erro! Tente novamente mais tarde" }];
                });
        }       
    }       
    
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.hero-title {
    font-size: 3.5rem;
}
</style>
