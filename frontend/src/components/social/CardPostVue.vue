<template>
    <span>
        <div v-if="txt" class="card-content px-3">
            <p>{{ txt }}</p>
        </div>

        <div v-if="img" class="card-image">
            <a v-if="link && link != '#'" :href="link" target="_blank">
                <img :src="img" class="card-img-top" />

				<div v-if="txt" class="card-content bg-light py-2 px-3 link-secondary">
					<span>{{ link }}</span>
					<h4 class="h4 text-black">{{ txt }}</h4>
				</div>

            </a>

            <img
                v-if="!link || link == '#'"
                :href="link"
                :src="img"
                class="card-img-top"
            />
			
        </div>

    </span>
</template>

<script>
export default {
    name: 'CardPostVue',
    props: ['img', 'txt', 'link'],
    data() {
        return {}
    },
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
</style>
