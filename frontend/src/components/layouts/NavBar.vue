<template>
    <span>
        <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
            <div class="container-fluid">
                <router-link to="/" class="navbar-brand">
                    <i class="fab fa-facebook fa-lg text-primary"></i>
                </router-link>
                <div
                    class="collapse navbar-collapse"
                    id="navbarSupportedContent"
                >
                    <form class="d-flex me-auto mb-2 mb-lg-0">
                        <div class="input-group rounded-pill">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="fas fa-search">

                                    </i>
                                </span>
                                <input
                                    class="form-control me-2 border-start-0"
                                    type="search"
                                    placeholder="Pesquisar"
                                    aria-label="Search"
                                />  
                        </div>                      
                    </form>
                    <ul class="navbar-nav">
                        <slot />
                    </ul>
                </div>
            </div>
        </nav>
    </span>
</template>

<script>
export default {
    name: "NavBar",
    props: ["logo", "url", "cor"],
    data() {
        return {};
    },
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
</style>
