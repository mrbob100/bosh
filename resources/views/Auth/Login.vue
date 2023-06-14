
<template>
    <form class="form" @submit.prevent="login">

        <h1 class="form-title">Welcome back!</h1>

        <div class="form-group">
            <label>Email</label>
            <input type="email" class="form-control" v-model="form.email">
            <small class="error-control" v-if="error.email">{{error.email[0]}}</small>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" class="form-control" v-model="form.password">
            <small class="error-control" v-if="error.password">{{error.password[0]}}</small>
        </div>



        <div class="form-group">
            <button :disabled="isProcessing" class="btn btn-primary">
                Login
            </button>
        </div>


    </form>
</template>

<script type="text/javascript">

    import Flash from '../../js/helpers/flash'
    import {post} from '../../js/helpers/api'



    export default {
        data(){
            return {
                form: {

                    email: '',
                    password: '',
                    panel: false

                },
                error: {},
                isProcessing: false
            }
        },



        methods: {
            login()
            {
                this.isProcessing = true;
                this.error ={};
                 console.log(this.form.email);
                post(`/api/login`,this.form).then((res) =>
                {

                    if(res.data.status)
                    {

                        this.isProcessing=false;
                        let as=res.data.role_id;
                        if(as==13)
                        {
                            this.panel=true;
                           // let tet =[res.data.api_token, res.data.user_id, res.data.role_id];
                         //   this.$store.commit('auth/set', tet);
                            this.$store.commit('auth/set', [res.data.api_token, res.data.user_id, res.data.role_id]);
                          // Auth.set(res.data.api_token, res.data.user_id, res.data.role_id);
                            this.$root.$emit('changeStatus', this.panel);
                            return 0;
                        }
                        Flash.setSuccess('You have successfully entered logged in!');
                        this.$store.commit('auth/set', [res.data.api_token, res.data.user_id, res.data.role_id]);
                        this.$router.push('/cabinet');

                    }
                    this.isProcessing=false
                })
                    .catch((err) =>{
                        if(err.response.status===422) {
                            this.error=err.response.data
                        }
                        this.isProcessing=false
                    })
            }
        }
    }
</script>

<style scoped>
    .form {
        margin-top: 100px;
        font-size: 1.4em;
    }
</style>
