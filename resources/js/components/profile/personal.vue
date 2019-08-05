<template>
  <div class="col-md-6">
    <div class="block-content">
      <form action method="post" @submit.prevent="sendCode(user.id)">
        <div class="form-group">
          <div class>
            <label for="email">Email</label>
            <input
              type="email"
              class="form-control"
              :value="email"
              id="email"
              disabled
              name="material-text"
            />
          </div>
        </div>

        <div class="form-group" v-if="user.email_verified_at == null">
          <div v-if="processing" class="col-6 col-md-3">
            <i class="fa fa-2x fa-cog fa-spin text-primary"></i>
          </div>
          <button
            v-else
            type="submit"
            class="btn btn-md bky-outline-primary mb-10"
          >Send verification email</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { RepositoryFactory } from "../../repository/RepositoryFactory";

const UsersRepository = RepositoryFactory.get("users");
export default {
  props: {
    email: String
  },
  data() {
    return {
      user: "",
      processing: false
    };
  },
  methods: {
    sendCode(id) {
      let data = {
        user: id
      };
      this.processing = true;
      UsersRepository.verifyEmail(data)
        .then(response => {
          this.processing = false;
          toast.fire({
            type: "success",
            title: "Verification email sent"
          });
        })
        .catch(() => {
          toast({
            type: "warning",
            title: "Failed to sent verification email"
          });
        });
    }
  },
  mounted() {
    axios.get('/api/user').then(response => {
      this.user = response.data;
    });
  }
};
</script>

<style scoped>
</style>
