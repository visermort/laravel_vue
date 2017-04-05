window.onload = function () {

    var app = new Vue({
        el: '#test',
        data: {
            message: 'Привет, это Vue!',
            message2: 'Это подсказка!',
            seen: true,
            todos: [
                { text: 'Learn JavaScript' },
                { text: 'Learn Vue' },
                { text: 'Build something awesome' }
            ],
            inputMessage: '',
            rawHtml: '<button> this is raw Html</button>',
            buttonValue: 'Пример биндим атрибут',
        },
        methods: {
            reverseMessage: function() {
                this.message = this.message.split('').reverse().join('');
            }
        }
    });

    Vue.component('todo-item', {
        // The todo-item component now accepts a
        // "prop", which is like a custom attribute.
        // This prop is called todo.
        props: ['todo'],
        template: '<li>{{ todo.text }}</li>'
    });

    Vue.component('comment-item', {
        //компонент для вывода списков
        props: ['item'],
        template: '<li>{{ item.text}}</li>'
    });

    var app7 = new Vue({
        el: '#app-7',
        data: {
            groceryList: [
                {text: 'Vegetables'},
                {text: 'Cheese'},
                {text: 'Whatever else humans are supposed to eat'}
            ],
            comments: 'Здесь будут комментарии',
            commentsList: []
        },
        
        methods: {
             getSomeGet: function(){
                 axios.get('/api/comments?dff=aaa', {
                     params: {'aaa': 'adfff'}
                 }).then(function (response) {
                         console.log(response.data);
                         app7.comments = response.data;
                     })
                     .catch(function (error) {
                         console.log(error);
                     })
                     .bind(app7);
            },
            getComments: function(){
                axios.get('/api/comments').then(function(response){
                    console.log(response.data);
                    app7.commentsList = response.data;
                }).bind(app7);
            }
            

        }
        
    });


};
