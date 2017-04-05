window.onload = function () {

    Vue.component('comment-item', {
        //компонент для вывода списков
        props: ['item'],
        template: '<li class="good_item">{{ item.id }} . {{ item.data }}  {{ item.text}}</li>'
    });

    var app7 = new Vue({
        el: '#app-7',
        data: {
            commentsList: []
        },
        methods: {
            getCommentsItems: function(){
                this.$http.get('/api/comments').then(function(response){
                // axios.get('/api/comments').then(function(response){
                   // console.log(response.data);
                    this.commentsList = response.data;
                   // console.log(app7.commentsList);
                }).catch(function (error) {
                    console.log(error);
                });//.bind(this);
            }
        }
    });
};
