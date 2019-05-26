<template>
    <div v-if="isError">
        error
    </div>

    <div v-else-if="isLoading">
        loading...
    </div>

    <div v-else>
        <h2>User {{ user.id }}</h2>

        {{ isValisUser }}
        <form>
            <label class="form-group d-block">
                <span class="control-label">First name</span>
                <input type="text" class="form-control" v-model="user.first_name" />
            </label>

            <label class="form-group d-block">
                <span class="control-label">Last name</span>
                <input type="text" class="form-control" v-model="user.last_name" />
            </label>

            <label class="form-group d-block">
                <span class="control-label">Email</span>
                <input type="text" class="form-control" v-model="user.email" />
            </label>

            <label class="form-group d-block">
                <span class="control-label">Username</span>
                <input type="text" class="form-control" v-model="user.username" />
            </label>

            <label class="form-group d-block">
                <span class="control-label">Password</span>
                <input type="text" class="form-control" v-model="user.password" />
                <span v-if="user.id !== 'new'">leave empty for not edit old password.</span>
            </label>

            <label class="form-group d-block">
                <input type="checkbox" class="_form-check-input" v-model="user.is_active" />
                <span class="form-check-label">Is active</span>
            </label>

            <p>created at: {{ user.created_at }};</p>
            <p>last updated time: {{ user.last_updated_time }}</p>

            <p v-if="! isValisUser" class="text-danger">User data not valid</p>

            <button v-if="user.id === 'new'" class="btn btn-success" :disabled="! isValisUser" @click="newUser">save</button>

            <button v-if="user.id !== 'new'" class="btn btn-success" :disabled="! isValisUser" @click="editUser">Save</button>
            <button v-if="user.id !== 'new'" class="btn btn-danger" @click="deleteUser">Delete</button>

            <button class="btn btn-info" @click="gotoUsersList">Cancel</button>
        </form>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        data(){
            return{
                isError: false,
                isLoading: false,
                id: 'new',
                user: {
                    id: 'new',
                    first_name: "",
                    last_name: "",
                    email: "",
                    username: "",
                    password: "",
                    created_at: Date.now(),
                    last_updated_time: Date.now(),
                    is_active: 1,
                },
            }
        },
        computed: {
            isValisUser(){
                return true;
                const password = this.user.password;

                const passwordIsValid = (
                    ( this.user.id !== 'new' && password === '')
                    || (
                        password.length >= 8 && /[A-Z]/.test(password)
                        && /[a-z]/.test(password) && /[0-9]/.test(password)
                        && /[^(A-Z)|(a-z)|(0-9)]/.test(password)
                    )
                );

                return ! (
                    this.user.first_name == ''
                    || this.user.last_name == ''
                    || this.user.username == ''
                    || ! /\S+@\S+\.\S+/.test(this.user.email)
                    || ! passwordIsValid
                );
            }
        },
        async mounted() {
            await this.init(this.$route.params.id);
        },
        watch: {
            '$route': async function(to, from) {
                await this.init(this.$route.params.id);
            }
        },
        methods: {
            gotoUsersList(){
                this.$router.push('/users');
            },
            async init(id){
                this.isLoading = true;

                if( id === 'new' ){
                    // nothing
                }else{
                    await this.loadUser(id);
                }

                this.isLoading = false;
            },
            async loadUser(id){
                await axios.get(`/api/user/${id}`)
                    .then(res => this.user = res.data)
                    .then(res => this.user.password = '')
                    .catch(() => this.isError = true);
            },
            async editUser(){
                if( ! this.isValisUser ){
                    alert("User data not valid!");
                    return;
                }

                this.isLoading = true;

                const headers = {
                    'Content-Type': 'application/json',
                }

                await axios.put(`/api/user/${this.user.id}`, this.user, {headers})
                    .then(res => res.data)
                    .then(data => {
                        if( ! data.success ){
                            throw data.msg;
                        }
                    })
                    .then(() => alert('Successfully saved'))
                    .catch(msg => {
                        this.isError = true;
                        alert(msg);
                    });

                this.isLoading = false;
            },
            async deleteUser(){
                this.isLoading = true;

                const headers = {
                    'Content-Type': 'application/json',
                }

                await axios.delete(`/api/user/${this.user.id}`, {headers})
                    .then(res => alert('Successfully deleted'))
                    .then(() => this.$router.push('/users'))
                    .catch(() => this.isError = true);

                this.isLoading = false;
            },
            async newUser(){
                if( ! this.isValisUser ){
                    alert("User data not valid!");
                    return;
                }

                this.isLoading = true;

                const headers = {
                    'Content-Type': 'application/json',
                }

                await axios.post('/api/user', this.user, {headers})
                    .then(res => res.data)
                    .then(data => {
                        if( ! data.success ){
                            throw data.msg;
                        }

                        this.$router.push(`/users/${res.id}`);
                        return data;
                    })
                    .then(() => alert('Successfully saved'))
                    .catch(msg => {
                        this.isError = true;
                        alert(msg);
                    });

                this.isLoading = false;
            }
        }
    }
</script>
