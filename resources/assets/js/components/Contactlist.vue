<template>
  <div class="contact-list">
    <ul>
      <li
        v-for="contact in sortedContacts"
        :key="contact.id"
        @click="selectedContact(contact)"
        :class="{ selected: contact == selected }"
      >
        <div class="avatar">
          <span class="img">{{ contact.name.charAt(0) }}</span>
        </div>
        <div class="contact">
          <p class="name">{{ contact.name }}</p>
          <p class="email">{{ contact.email }}</p>
        </div>
        <span class="unread" v-if="contact.unread">{{ contact.unread }}</span>
      </li>
    </ul>
  </div>
</template>
<script>
export default {
  name: "Contactlist",
  props: {
    contacts: {
      type: Array,
      default: []
    }
  },
  data() {
    return {
      selected: this.contacts.length ? this.contacts[0] : null
    };
  },
  methods: {
    selectedContact(contact) {
      this.selected = contact;
      this.$emit("selected", contact);
    }
  },
  computed: {
    sortedContacts() {
      return _.sortBy(this.contacts, [
        contact => {
          if (contact == this.selected) {
            return Infinity;
          }
          return contact.unread;
        }
      ]).reverse();
    }
  },
  mounted() {}
};
</script>

<style lang="scss" scoped>
.contact-list {
  flex: 2;
  max-height: 700px;
  overflow: scroll;
  border-left: 1px solid #a6a6a6;
  ul {
    list-style: none;
    padding-left: 0;

    li {
      display: flex;
      padding: 2px;
      border-bottom: 1px solid #aaaaaa;
      height: 80px;
      position: relative;
      cursor: pointer;

      &.selected {
        background-color: #a6a6a6;
      }

      span.unread {
        background: #009688;
        color: #ffffff;
        position: absolute;
        right: 11px;
        top: 15px;
        display: flex;
        font-weight: 500;
        min-width: 20px;
        justify-content: center;
        line-height: 20px;
        font-size: 12px;
        padding: 0 4px;
        border-radius: 50%;
      }

      .avatar {
        flex: 1;
        display: flex;
        align-items: center;
        span {
          width: 35px;
          height: 35px;
          border-radius: 50%;
          margin: 0 auto;
          background-color: #009688;
          text-align: center;
          padding-top: 5px;
        }
      }
      .contact {
        flex: 3;
        font-size: 10px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        justify-content: center;
        p {
          margin: 0;

          &.name {
            font-weight: bold;
          }
        }
      }
    }
  }
}
</style>
