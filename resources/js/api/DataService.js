
    function getData(path) {
        const baseUrl = '/api';

        let url = `${baseUrl}/${path}`;
        return axios.get(`${url}`);
    }

    function  fetchPosts() {
        return getData('posts');
    }

    function fetchComments(post) {
        return getData(`comments/${post}`);
    }

export {fetchPosts, fetchComments};

