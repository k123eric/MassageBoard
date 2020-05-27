<!DOCTYPE html>

<html>

    <head>
        <meta charset="utf-8">
        <title>留言板</title>
        <script src="//code.jquery.com/jquery-3.5.1.min.js"
            integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
        <script src="//cdn.jsdelivr.net/gh/jquery-form/form@4.2.2/dist/jquery.form.min.js"
            integrity="sha384-FzT3vTVGXqf7wRfy8k4BiyzvbNfeYjK+frTVqZeNDFl8woCbF0CYG6g2fMEFFo/i"
            crossorigin="anonymous"></script>
        <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/semantic-ui@2.4.2/dist/semantic.min.css">
        <script src="//cdn.jsdelivr.net/npm/semantic-ui@2.4.2/dist/semantic.min.js"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>

        <link rel="stylesheet" href="<?= base_url("assets/css/style.css") ?>">
        <script src="<?= base_url("assets/js/post.js") ?>">"</script>
        <meta id="site_url" content="<?= site_url() ?>">
    </head>

    <body>
        <div id="new_post">
            <button class="ui green labeled icon button"><i class="plus icon"></i>新增文章</button>
        </div>

        <div class="search">
            <div class="ui large action input">
                <input id="search" type="text" placeholder="Search...">
                <button class="ui icon search button">
                    <i class="search icon"></i>
                </button>
            </div>
        </div>

        <div id="content">
            <post :id="'Post_ '+ post.id" v-for="post in posts" :post_data="post"> 載入中</post>
        </div>

        <div class="ui modal">
            <div class="header">文章</div>
            <div class="content">
                <form class="ui form">
                    <input name="id" type="hidden">
                    <label for="title">留言標題：</label>
                    <input name="title" type="text">
                    <label for="content">留言內容：</label>
                    <textarea name="content" rows="30" cols="60" class="ui input"></textarea>
                </form>
            </div>
            <div class="actions">
                <div class="ui negative labeled icon button"><i class="close icon"></i>取消</div>
                <div class="ui primary labeled icon button"><i class="trash alternate outline icon"></i>刪除</div>
                <div class="ui positive labeled icon button"><i class="checkmark icon"></i>送出</div>
            </div>
        </div>
    </body>

    <template id="post_template">
        <div class="post">
            <div class="header">
                <h3 class="ui header">
                    <span class="title"></span>{{ post_data.title }}
                    ｜
                    <span class="author"></span>{{ post_data.author ?? "匿名"}}
                    @
                    <span class="time"></span>{{ post_data.Uploadtime }}
                </h3>
            </div>
            <hr>
            <div class="body">
                {{ post_data.content }}
            </div>
            <hr>
            <div class="buttons">
                <div class="ui labeled button" tabindex="0">
                    <div class="ui circular orange button" data-tooltip="GP讓勇者獲得力量!" data-inverted=""
                        data-position="bottom left" @click="gp">
                        <i class="thumbs up icon"></i> GP
                    </div>
                    <a class="ui basic left pointing label gp">{{ post_data.gp }}</a>
                </div>
                <div class="ui labeled button" tabindex="0">
                    <div class="ui circular black button" data-tooltip="BP讓文章削弱光芒!" data-inverted=""
                        data-position="bottom left" @click="bp">
                        <i class="thumbs down icon"></i> BP
                    </div>
                    <a id="bp" class="ui basic left pointing label bp">{{ post_data.bp }}</a>
                </div>
                <button class=" ui blue labeled icon edit button" style="float:right" @click="edit"><i
                        class="edit outline icon"></i>編輯</button>
                <button class="ui red labeled icon delete button" style="float:right" @click="remove"><i
                        class="trash alternate outline icon"></i>刪除</button>
            </div>
        </div>
    </template>

</html>