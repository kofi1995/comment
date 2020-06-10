<template>
    <ul class="list-group">
        <template v-for="comment in comments">
            <comment v-bind:comment="comment" v-bind:collection="collection"></comment>
        </template>
    </ul>
</template>
<script>
    export default{
        props: ['collection','comments'],
        computed:{
        },
        beforeCreate: function () {
            this.$options.components.Comment = require('./CommentComponent').default
        }
    }
</script>
