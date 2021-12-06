<template>
  <div>
      <ContactListItem v-for="friend in listFriends" :key="friend.id"
        :friendImage="friend.image"
        :friendName="friend.name"
      >                    
      </ContactListItem>
  </div>
</template>

<script>
import ContactListItem from './ContactListItem.vue'

export default {
    components: {
        ContactListItem
    },
    props: ['listFriends'],
}
</script>

<style>

</style>