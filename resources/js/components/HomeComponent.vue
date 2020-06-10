<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Home Component</div>

                    <div class="card-body">
                        <div class="card mt-1" v-if="posts" v-for="post in posts">
                            <div class="card-header"><a v-bind:href="'/post/'+ post.id">{{post.title}}</a></div>
                            <div class="card-body"><span v-html="post.message"></span></div>
                            <div class="card-footer">
                                <a class="btn btn-primary" v-bind:href="'/post/'+ post.id" role="button">Read More</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data () {
            return {
                loading: false,
                posts: null,
                error: null
            }
        },
        created () {
            this.fetchData()
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods: {
            fetchData () {
                this.error = this.post = null;
                this.loading = true;
                axios.get('/api/posts').then((res) => {
                    this.posts = res.data.data;

                }).catch(function (error) {
                    this.error = error;
                });
            }
        }
    }
</script>
