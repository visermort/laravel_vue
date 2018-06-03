

Vue.component('treecontent', require('./components/vs-tree/sample-content/tree-content.vue'));
Vue.component('vs-tree', require('./components/vs-tree/tree.vue'));

let treecontent = new Vue ({
   el: '#tree-content'
});

let tree = new Vue ({
   el: '#tree',
   data: function() {
       return {
           url: '/api/goods2'
       };
   }
});

