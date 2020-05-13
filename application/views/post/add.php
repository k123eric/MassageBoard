<h1 style="text-align: center;">新增留言</h1>
<form style="max-width: 600px; margin: 0 auto;" method="post" action="/post.php">

    <div style="margin: 10px;">
        <label for=" title">標題</label>
        <input type="text" name="title">
    </div>
    <div style="margin: 10px;">
        <label for="content">內容</label><br>
        <textarea cols="80" rows="20" name="content" required></textarea>
    </div>
    <div>
        <button type="submit">送出</button>
        <button type="button" onClick="cancel()" ;>取消</button>
    </div>
    <?php
        function cancel(){
            $this->load->view('first_page');
        }
    ?>
</form>