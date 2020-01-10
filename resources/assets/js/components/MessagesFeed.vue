<template>
    <div class="feed" ref="feed">
        <ul v-if="contact">
            <li
                v-for="message in messages"
                :class="
                    `message${message.to == contact.id ? 'sent' : 'received'}`
                "
                :key="message.id"
            >
                <div class="text">{{ message.message }}</div>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    props: {
        contact: {
            type: Object
        },
        messages: {
            type: Array,
            required: true
        }
    },
    methods: {
        scrollToBottom() {
            setTimeout(() => {
                this.$refs.feed.scrollTop =
                    this.$refs.feed.scrollHeight - this.$refs.feed.clientHeight;
            }, 50);
        }
    },
    watch: {
        contact(contact) {
            this.scrollToBottom();
        },
        messages(messages) {
            this.scrollToBottom();
        }
    }
};
</script>

<style lang="scss" scoped>
.feed {
    background: #ffffff;
    height: 100%;
    max-height: 580px;
    overflow: scroll;

    ul {
        list-style-type: none;
        padding: 5px;
        li {
            margin: 10px 0;
            width: 100%;
            .text {
                max-width: 400px;
                border-radius: 50px;
                padding: 5px;
                display: inline-block;
            }

            &.messagereceived {
                text-align: left;
                .text {
                    background: #f1f0f0;
                    text-align: left;
                    padding: 0 12px 0 12px;
                }
            }
            &.messagesent {
                text-align: right;
                .text {
                    background: #0099ff;
                    color: #ffffff;
                    text-align: left;
                    padding: 0 12px 0 12px;
                }
            }
        }
    }
}
</style>
