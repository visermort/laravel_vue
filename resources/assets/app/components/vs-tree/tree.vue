<template>
    <ul class="tree-item__list" id="vs-tree">
        <tree-item class="tree-item" v-for="modelparent in treeData" :key="modelparent" :model="modelparent"></tree-item>
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

    .tree-item {
        cursor: pointer;
        line-height: 1.5em;
        list-style-type: none;
    }

    .tree-item__node {
        display: block;
        width: 18px;
        height: 18px;
        background-image: url(images/arrow_right.png);
        float: left;
        margin-top: 4px;
    }

    .tree-item__node.open {
        background-image: url(images/arrow_expanded.png);
    }

    .tree-item__node.document {
        background-image: url(images/document.gif);
        cursor: default;
    }

    .tree-item__node.loading {
        background-image: url(images/loader.gif);
        cursor: default;
    }

    .tree-item__title {
        display: block;
        line-height: 1.8;
        padding-left: 20px;
    }

    .tree-item__list {
        padding-left: 2em;
    }

</style>
