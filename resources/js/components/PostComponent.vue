<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8" v-if="post">
                <div class="card">
                    <div class="card-header">{{post.title}}</div>
                    <div class="card-body">
                        <span v-html="post.message"></span></div>
                    </div>
                    <div class="card-footer">
                        <div class="col-md-12">
                            <input type="text" class="form-control" v-model="reply" placeholder="leave a comment..."
                                   v-on:keyup.enter="comment()">
                        </div>
                        <div class="col-md-12">
                            <comment-list v-if="post.comments" :collection="post.comments" :comments="post.comments.root"></comment-list>
                        </div>
                        <div class="clearfix"></div>
                    </div>
            </div>
        </div>
    </div>
</template>

<script>
    import CommentListComponent from './CommentListComponent';

    export default {
        props: ['postId'],
        data () {
            return {
                loading: false,
                error: null,
                reply: ''
            }
        },
        created () {
            this.fetchData()
        },
        computed: {
            post(){
                return this.$store.state.post;
            }
        },
        components: {
            'comment-list': CommentListComponent
        },
        mounted() {
            console.log('Component mounted.')
        },
        methods: {
            fetchData () {
                this.error = null;
                this.loading = true;
                axios.get(`/api/post/${this.postId}`).then((res) => {
                    this.$store.commit('updatePost', res.data);

                }).catch(function (error) {
                    this.error = error.response.data;
                });
            },
            comment(){
                axios.post(`/api/comment/${this.postId}`, {message: this.reply}).then(res => {
                        this.$store.commit('updateComments', res.data.comments);
                        this.reply = '';
                        window.scrollTo(0,document.body.scrollHeight);
                }).catch(error => {
                    console.log(error.response)
                });
            }
        }
    }
</script>
