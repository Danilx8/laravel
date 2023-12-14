<template>
    <div v-show="this.msg != null" class="alert alert-primary" role="alert">
        Добавлена новая статья <strong>{{this.msg}}</strong>
    </div>
</template>
<script>
    export default {
    data() { return { msg: null } },
        created() {
            window.Echo.channel('dev').listen('NewArticleEvent', (name) => {
                console.log(name.article);
                this.msg=name.article;
                alert('Добавлена новая статья!');
            })
        }
    }
</script>
