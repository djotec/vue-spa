<template>
    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <div class="row align-items-center">
                <grid-vue tamanho="1">
                    <img
                        :src="user.image"
                        :alt="user.name"
                        class="img-fluid rounded-circle"
                    />
                </grid-vue>

                <grid-vue tamanho="11">
                    <div>
                        <input
                            v-model="content.text"
                            class="form-control rounded-pill bg-light"
                            type="text"
                            :placeholder="`No que você está pensando, ${user.name}?`"
                            aria-label="default input example"
                        />
                    </div>
                    <div v-if="content.text" class="my-3">
                        <input
                            v-model="content.image"
                            class="form-control bg-light"
                            type="text"
                            placeholder="Url da imagem"
                            aria-label="default input example"
                        />
                    </div>
                    <div v-if="content.text" class="mt-3">
                        <input
                            v-model="content.link"
                            class="form-control bg-light"
                            type="text"
                            placeholder="Link"
                            aria-label="default input example"
                        />
                    </div>
                </grid-vue>
            </div>
            <div class="row align-items-center">
                <div v-if="content.text && content.image" class="text-end">
                    <button
                        @click="addContent"
                        type="button"
                        class="btn btn-primary"
                    >
                        Publicar
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import GridVue from '@/components/layouts/GridVue'

export default {
    name: 'PublicarConteudoVue',
    components: {
        GridVue,
    },
    data() {
        return {
            content: {
                text: '',
                link: '',
                image: '',
            },
            user: false,     
            erros: [],
        }
    },
    created() {
        let userAux = this.$store.getters.getUser
        if (userAux) {
            this.user = this.$store.getters.getUser
        }
    },
    methods: {
        clearPostForm() {
            this.content = {
                text: '',
                link: '',
                image: '',
            }
        },
        addContent() {
            this.erros = [];
            this.$http
                .post(this.$urlApi + 'content/add', this.content, {
                    headers: {
                        Authorization: `Bearer ${this.$store.getters.getToken}`,
                    },
                })
                .then(({ data }) => {
                    if (data.success) {
                        console.log(data)
                        this.clearPostForm();
                        const responseData = data.data
                        this.$store.commit(
                            'setContentsTimeline',
                            responseData.data
                        )
                    } else if (data.success == false && data.errors) { 
                        //erros de validação
                        console.log("erros de validação");
                        this.erros = Object.values(data.errors);  
                        console.log (this.erros);
                    }
                })
        },
    },
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
</style>
