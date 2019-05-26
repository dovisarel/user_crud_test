<template>
    <div>
        <h2>Users list</h2>

        <div v-if="isError">
            error
        </div>

        <div v-else-if="isLoading">
            loading...
        </div>

        <div v-else>
            <p>
                <button class="btn btn-info" @click="gotoUserNew">New User</button>
            </p>

            <table class="table table-bordered table-striped">
                <tr>
                    <th>id</th>
                    <th>first_name</th>
                    <th>last_name</th>
                    <th>email</th>
                    <th>username</th>
                    <th>password</th>
                    <th>created_at</th>
                    <th>last_updated_time</th>
                    <th>is_active</th>
                </tr>

                <tr v-for="u in users" :key="u.id" @click="gotoUserEdit(u.id)">
                    <th>{{ u.id }}</th>
                    <th>{{ u.first_name }}</th>
                    <th>{{ u.last_name }}</th>
                    <th>{{ u.email }}</th>
                    <th>{{ u.username }}</th>
                    <th>{{ u.password }}</th>
                    <th>{{ u.created_at }}</th>
                    <th>{{ u.last_updated_time }}</th>
                    <th>{{ u.is_active }}</th>
                </tr>
            </table>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        data(){
            return{
                isError: false,
                isLoading: false,
                users: [],
            }
        },
        async mounted() {
            await this.loadUsers();
        },
        methods: {
            gotoUserEdit(id){
                this.$router.push(`/users/${id}`);
            },
            gotoUserNew(){
                this.$router.push('/users/new');
            },
            async loadUsers(){
                this.isLoading = true;

                await axios.get('/api/user')
                    .then(res => this.users = res.data)
                    .catch(() => this.isError = true);

                this.isLoading = false;
            }
        }
    }
</script>
