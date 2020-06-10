<template>
    <div>
        <input type="text" v-model="reply" class="form-control" v-on:keyup.enter="replyTo(comment)">
    </div>
</template>
<style>
</style>
<script>
    export default{
        props: ['comment'],
        data(){
            return{
                reply: '',
                success: null,
                error: null
            }
        },
        methods:{
            replyTo(comment){
                this.success = null;
                this.error = null;
                axios.post(`/api/comment/${comment.post_id}`, {message: this.reply, post_id: comment.post_id, parent_id: comment.id}).then(res => {
                   this.reply = '';
                   this.$store.commit('updateComments', res.data.comments);
                    alert('Comment Posted');
            }).catch(error => {
                    alert(error.response.data.message);
                });
            }
        }
    }
</script>
