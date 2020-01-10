<template>
    <div class="composer">
        <textarea
            v-model="message"
            @keydown.enter="send"
            placeholder="Type a message..."
            
        ></textarea>
        <i
        @click="send"
            class="fas fa-paper-plane mdl-button mdl-btn mdl-button mdl-js-button mdl-button--icon mdl-js-ripple-effect mdl-color-text--blue"
        ></i>
    </div>
</template>

<script>
export default {
    data() {
        return {
            message: ""
        };
    },
    methods: {
        send(e) {
            e.preventDefault();
            if (this.message == "") {
                return;
            }
            this.$emit("send", this.message);
            this.message = "";
        }
    }
};
</script>
<style lang="scss" scoped>
.composer {
    display: flex;
    textarea {
        width: 96%;
        margin: 10px;
        resize: none;
        border-radius: 50px;
        border: none;
        padding: 6px 10px;
        background: #dbd5d5;
        outline: none;
        height: 35px;
    }
    i {
        font-size: 20px;
        padding-top: 5px;
        margin: 10px 10px 10px 0px;
    }
}
</style>
