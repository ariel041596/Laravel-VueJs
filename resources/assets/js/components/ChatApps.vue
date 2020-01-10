<template>
  <div class="chat-apps">
    <Conversation :contact="selectedContact" :messages="messages" @new="saveNewMessage"></Conversation>
    <Contactlist :contacts="contacts" @selected="startConversationWith"></Contactlist>
  </div>
</template>

<script>
import Contactlist from "./Contactlist";
import Conversation from "./Conversation";
export default {
  name: "chat-apps",
  props: {
    user: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      selectedContact: null,
      messages: [],
      contacts: []
    };
  },
  components: { Contactlist, Conversation },
  mounted() {
    // Start of pusher-js
    Echo.private(`messages.${this.user.id}`).listen("NewMessage", e => {
      this.handleIncoming(e.message);
    });
    axios.get("api/contacts").then(response => {
      this.contacts = response.data;
    });
    // axios.get("api/userObject").then(response => {
    //   this.user = response.data;
    // });
    // axios.get("api/profileID").then(response => {
    //   this.users = response.data;
    //   console.log(this.users);
    // });
  },
  methods: {
    startConversationWith(contact) {
      this.updateUnreadCount(contact, true);
      axios.get(`api/conversation/${contact.id}`).then(response => {
        this.messages = response.data;
        this.selectedContact = contact;
      });
    },
    saveNewMessage(message) {
      this.messages.push(message);
    },
    handleIncoming(message) {
      if (this.selectedContact && message.from == this.selectedContact.id) {
        this.saveNewMessage(message);
        return;
      }
      // return;
      // alert(message.message);
      this.updateUnreadCount(message.from_contact, false);
    },
    updateUnreadCount(contact, reset) {
      this.contacts = this.contacts.map(single => {
        if (single.id !== contact.id) {
          return single;
        }
        if (reset) {
          single.unread = 0;
        } else {
          single.unread += 1;
        }
        return single;
      });
    }
  }
};
</script>

<style lang="scss" scoped>
.chat-apps {
  display: flex;
}
</style>
