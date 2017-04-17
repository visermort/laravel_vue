<script>
// window.onload = function () {

    Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('content');

    //instance for events
    //используем для передачи событий между компонентами
    //а также при инициализации, после загрузки конфигурации - команда из инстанса компоненту сделать запрос
    var bus = new Vue({});

// };
</script>