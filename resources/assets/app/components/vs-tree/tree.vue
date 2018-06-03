<template>
    <ul class="tree-item__list" id="vs-tree">
        <tree-item class="tree-item" v-for="modelparent in treeData" :model="modelparent"></tree-item>
    </ul>
</template>

<script>
    require('./tree-item.js');

    export default {
        props: {
            url: '',
            //treeData: []
        },
        data: function() {
            return {
                treeData: [],
            }
        },
        methods: {
            getChilds: function(url){
                //var that = this;
                this.$http.get(url).then(function(response){
                    console.log(response.data);
                    this.treeData = response.data;
                }).catch(function (error) {
                    console.log(error);
                });
            },
        },
        mounted: function() {
            //после загрузки грузим данные
            console.log(this.url);
            this.getChilds(this.url);
        }
    }


</script>

<style>

</style>