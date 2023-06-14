<template>
    <div class="container">
        <div class="navbar">
            <div class="navbar-brend" >
                <router-link to="/">Recipe  box</router-link>

            </div>
            <ul class="navbar-list">
                <li class="nav navbar-item" v-if="!check">
                    <router-link to="/login">LOGIN</router-link>
                </li>
                <li class="nav navbar-item" v-if="!check">
                    <router-link to="/register">REGISTER</router-link>
                </li>
                <li class="navbar-item" v-if="check">
                    <router-link to="/recipes/create">CREATE RECIPE</router-link>
                </li>
                <li class="navbar-item"  v-if="check">
                    <a @click.stop="logout">LOGOUT</a>
                </li>
            </ul>

        </div>
        <div class="flash flash-success" v-if="flash.success">
            {{flash.success}}
        </div>

        <div class="flash flash-error" v-if="flash.error">
            {{flash.error}}
        </div>
        <router-view></router-view>

    </div>
</template>
<script>

    import Auth from '../store/modules/auth'
    import flash from '../helpers/flash'
    import { post } from '../helpers/api'

    export default {

        created(){
            Auth.initialize()
        },

        data(){
            return {
                flash: flash.state,
                auth: Auth.state
            }
        },
        computed: {

            check()
            {

                if(this.auth.api_token && this.auth.user_id) {
                    return true;
                }
                return false;
            }
        },
        methods: {

            logout()
            {
                post(`/api/logout`).then((res)=>{
                    if(res.data.logged_out)
                    {
                        Auth.remove();
                        flash.setSuccess('You have successfully logged out!');
                        this.$router.push('/login');
                    }
                })
            }
        }
    }
</script>