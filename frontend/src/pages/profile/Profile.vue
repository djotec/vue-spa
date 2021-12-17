<template>
    <FullWidthTemplate>
        <span slot="principal">
            <section class="bg-white border-bottom mb-3">
                <div class="container">
                    <div class="row mb-4 justify-content-center">
                        <div class="col-sm-8">
                            <div class="card border-0">
                                <div class="profile-cover rounded-2">
                                    <img
                                        src="https://scontent.fthe11-1.fna.fbcdn.net/v/t1.6435-9/s960x960/95215567_1978125858987408_3147256591745548288_n.jpg?_nc_cat=107&ccb=1-5&_nc_sid=e3f864&_nc_eui2=AeE6DsGp-yvKN_XS8aN7I-Gwo68BJt0pKyijrwEm3SkrKCMaQ71Q3-2qDW1qeNbET6LZoiHg9yT4RckfoU_4swL9&_nc_ohc=hDLPcMd_6JwAX8XLZnq&_nc_ht=scontent.fthe11-1.fna&oh=a7b4d91e0065266d70649b10a40c17a4&oe=61CBA909"
                                        class="card-img-top"
                                        alt="..."
                                    />
                                </div>
                                <div class="card-body profile-info">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <img
                                                :src="owner.image"
                                                :alt="owner.name"
                                                class="
                                                    rounded-circle
                                                    img-fluid
                                                    me-3
                                                    profile-pic
                                                    border border-3 border-white
                                                "
                                                width="150"
                                                height="150"
                                            />
                                        </div>
                                        <div class="col-md-6">
                                            <h1>{{ owner.name }}</h1>
                                        </div>
                                        <div class="col-md-3">
                                            <button
                                                v-if="isFriendPage"
                                                @click="follow(owner.id)"
                                                class="btn" :class="isFriend ? 'btn-secondary' : 'btn-primary' "
                                            >
                                                {{ isFriend ? 'Seguindo' : 'Seguir' }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-sm-8">
                            <div class="row">
                                <div class="col-sm-5">
                                    <div class="card shadow-sm w-100 mb-3">
                                        <div class="card-body ">
                                            <h4 class="text-dark">Amigos</h4> 
                                            <div class="row">
                                                
                                                <div class="col-sm-4" v-for="item in friendsList" :key="item.id">
                                                    <router-link :to="'/'+item.id+'/'+$slug(item.name)" class="nav-link text-black p-0"> 
                                                                <img :src="item.image" class="card-img-top rounded-2" :alt="item.name">
                                                                    <span class="text-dark">{{ item.name }}</span>
                                                    </router-link>
                                                </div>
                                                
                                            </div>
                                            
                                        </div>
                                    </div>
                                    <div v-if="followers.length" class="card shadow-sm w-100 mb-3">
                                        <div class="card-body ">
                                            <h4 class="text-dark">Seguidores</h4> 
                                            <div class="row">
                                                
                                                <div class="col-sm-4" v-for="item in followers" :key="item.id">
                                                    <router-link :to="'/'+item.id+'/'+$slug(item.name)" class="nav-link text-black p-0"> 
                                                                <img :src="item.image" class="card-img-top rounded-2" :alt="item.name">
                                                                    <span class="text-dark">{{ item.name }}</span>
                                                    </router-link>
                                                </div>
                                                
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-7">
                                    <card-conteudo-vue
                                        v-for="item in listContents"
                                        :key="item.id"
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
                                    <div v-scroll="handleScroll"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </span>
    </FullWidthTemplate>
</template>

<script>
import ContactList from '@/components/ContactList.vue'
import FullWidthTemplate from '@/templates/FullWidthTemplate'
import CardConteudoVue from '@/components/social/CardConteudoVue'
import CardPostVue from '@/components/social/CardPostVue'
import CardMenuVue from '@/components/layouts/CardMenuVue.vue'
import PublicarConteudoVue from '@/components/social/PublicarConteudoVue'
import GridVue from '@/components/layouts/GridVue.vue'
import FooterVue from '@/components/layouts/FooterVue'

export default {
    name: 'Profile',
    components: {
        FullWidthTemplate,
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
            user: false,
            urlNextPage: null,
            stopscroll: false,
            owner: { image: '', name: '' },
            isFriendPage: false,
            friendsList: [],
            followers: [],
            friendsLoggedList: [],
        }
    },
    computed: {
        listContents()  {
            return this.$store.getters.getContentsTimeline;
        },
        isFriend() {

            for ( let friend of this.friendsLoggedList ) {    
                if ( friend.id == this.owner.id ) return true;
            }
            return false;
        }
    },
    watch: {
        '$route': 'refreshPage'
    },
    methods: {
        follow(id) {

            this.$http
                .post(
                    this.$urlApi + `user/friend/`,
                    { id: id },
                    {
                        headers: {
                            Authorization: `Bearer ${this.$store.getters.getToken}`,
                        },
                    }
                )
                .then(({ data }) => {                    
                    const responseData = data.data
                    if (data.success) {
                        this.friendsLoggedList = responseData.friends;
                        this.followers = responseData.followers;
                        // this.isFriend();
                    }
                })
                .catch((e) => {
                    console.log(e)
                })
        },

        loadProfileFriendsList(id) {
            this.$http
                .get(this.$urlApi + `user/friendsListProfile/` + id, {
                    headers: {
                        Authorization: `Bearer ${this.$store.getters.getToken}`,
                    },
                })
                .then(({ data }) => {
                    const responseData = data.data

                    if (data.success) {
                        this.friendsList = responseData.friends;
                        this.followers = responseData.followers;
                        this.friendsLoggedList = responseData.friendsLogged;
                        // this.isFriend();
                        console.log(data)
                    } else {
                        console.log(data.errors)
                    }
                })
                .catch((e) => {
                    console.log(e)
                })

            console.log('loadFriends')
        },       

        loadContentList() {
            this.$http
                .get(
                    this.$urlApi +
                        `content/profile/list/` +
                        this.$route.params.id,
                    {
                        headers: {
                            Authorization: `Bearer ${this.$store.getters.getToken}`,
                        },
                    }
                )
                .then(({ data }) => {
                    console.log(data)
                    const responseData = data.data

                    if (data.success) {
                        this.$store.commit(
                            'setContentsTimeline',
                            responseData.contents.data
                        )
                        this.urlNextPage = responseData.contents.next_page_url
                        this.stopscroll = false
                        this.owner = responseData.owner

                        if (this.owner.id != this.user.id) {
                            this.isFriendPage = true
                        }

                        this.loadProfileFriendsList(this.owner.id);
                    }
                    console.log(this.contents)
                })
                .catch((e) => {
                    console.log(e)
                })
        },
        loadPagination() {
            if (!this.urlNextPage) {
                return
            }
            this.$http
                .get(this.urlNextPage, {
                    headers: {
                        Authorization: `Bearer ${this.$store.getters.getToken}`,
                    },
                })
                .then(({ data }) => {
                    console.log(data)
                    const responseData = data.data

                    if (data.success && this.route.name == 'Profile') {
                        this.$store.commit(
                            'setPaginationContentsTimeline',
                            responseData.data
                        )
                        this.urlNextPage = responseData.next_page_url
                        this.stopscroll = false
                    }
                    console.log(this.contents)
                })
                .catch((e) => {
                    console.log(e)
                })
        },

        handleScroll() {
            // console.log(window.scrollY);
            // console.log(document.body.clientHeight);
            if (this.stopscroll) {
                return
            }
            if (window.scrollY >= document.body.clientHeight - 987) {
                this.stopscroll = true
                this.loadPagination()
            }
        },
        loadUser() {
            let userAux = this.$store.getters.getUser
            if (userAux) {
                this.user = this.$store.getters.getUser
            }
        },
        refreshPage(){
            this.loadUser()
            this.loadContentList()
        }
    },
    created() {
        this.refreshPage();
    },
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
.profile-cover {
    min-height: 264px;
    position: relative;
    overflow: hidden;
}
.profile-cover img {
    position: absolute;
    left: 0;
    top: 0;
    width: 100%;
    display: block;
}

.profile-pic {
    margin-top: -64px;
    z-index: 20;
    position: relative;
}
</style>
