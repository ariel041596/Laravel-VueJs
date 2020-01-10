<template>
    <div class="conversation">
        <h1>{{ contact ? contact.name : "Select a Contact" }}</h1>
        <MessagesFeed :contact="contact" :messages="messages"></MessagesFeed>
        <MessageComposer @send="sendMessage"></MessageComposer>
    </div>
</template>

<script>
import MessagesFeed from "./MessagesFeed";
import MessageComposer from "./MessageComposer";
export default {
    name: "Conversation",
    props: {
        contact: {
            type: Object,
            default: null
        },
        messages: {
            type: Array,
            default: []
        }
    },
    data() {
        return {};
    },
    methods: {
        sendMessage(message) {
            if (!this.contact) {
                return;
            }
            axios
                .post("api/conversation/send", {
                    contact_id: this.contact.id,
                    message: message
                })
                .then(response => {
                    this.$emit("new", response.data);
                });
        }
    },
    components: { MessagesFeed, MessageComposer },
    mounted() {}
};
</script>

<style lang="scss" scoped>
.conversation {
    flex: 5;
    display: flex;
    flex-direction: column;
    justify-content: space-between;

    h1 {
        font-size: 20px;
        padding: 10px;
        margin: 0;
        border-bottom: 1px dashed lightgray;
    }
}
</style>
