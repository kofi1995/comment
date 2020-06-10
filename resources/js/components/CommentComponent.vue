<template>
    <li class="list-group-item pl-5">
        {{ comment.message }}
        <p>Date posted: <small class="text-muted">{{comment.posted_date}}</small></p>
        <div>
            <a class="btn btn-info" @click="replyToComment = comment">Reply</a>
        </div>
        <comment-form v-if="replyToComment == comment" :comment="comment"></comment-form>
        <i-comment-list v-if="collection[comment.id]" v-bind:comments="collection[comment.id]" v-bind:collection="collection"></i-comment-list>
    </li>
</template>
<script>
    import CommentListComponent from './CommentListComponent';
    import CommentFormComponent from './CommentFormComponent';

    export default{
        props: ['comment', 'collection'],
        data(){
            return {
                replyToComment: false
            }
        },
        mounted(){
        },
        components: {
            'i-comment-list': CommentListComponent,
            'comment-form': CommentFormComponent
        }
    }
</script>
