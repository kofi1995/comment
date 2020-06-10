import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export const store = new Vuex.Store({

    state: {
        post: null,
    },

    mutations: {
        updatePost(state, post) {
            state.post = post;
        },
        updateComments(state, comments) {
            state.post.comments = comments;
        }
    }
});
