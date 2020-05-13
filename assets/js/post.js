jQuery(document).ready(initialize);

function initialize() {
    // const site_url = jQuery("meta#site_url").attr("content");
    post_get_all(); // undefined
}

function popup_window(id, title, title_editable, content) {
    let modal = jQuery(".ui.modal");
    modal.find(".header").text(title_editable ? "新增文章" : "編輯文章");
    modal.find("[name=id]").val(id);
    modal.find("[name=title]").val(title);
    modal.find("[name=title]").attr("disabled", !title_editable);
    modal.find("[name=content]").html(content);
    modal.find("[name=content]").attr("disabled", false);
    modal.modal('show');
    modal.find(".primary.button").hide();
    modal.find(".positive.button").show();
    modal.find(".positive.button").on("click", title_editable ? submit_release_handler : submit_edit_handler);
}

function popup_delete_window(id, title, content) {
    let modal = jQuery(".ui.modal");
    modal.find(".header").text("刪除文章");
    modal.find("[name=id]").val(id);
    modal.find("[name=title]").val(title);
    modal.find("[name=title]").attr("disabled", true);
    modal.find("[name=content]").html(content);
    modal.find("[name=content]").attr("disabled", true);
    modal.modal('show');
    modal.find(".positive.button").hide();
    modal.find(".primary.button").show();
    modal.find(".primary.button").on("click", submit_delete_handler);
}


async function post_get_all() {
    const posts = await api_get_all_post();   
    const post_template = await get_template("post");
    jQuery("#content").empty();
    posts.forEach(post_data => {  
        let post_html = jQuery(post_template);
        post_html.attr("id", post_data.id);
        post_html.find(".title").text(post_data.title);
        post_html.find(".author").text("匿名");
        post_html.find(".time").text(post_data.Upload_time);
        post_html.find(".time").attr("title", `最後更新時間：${post_data.Update_time}`);
        post_html.find(".body").html(post_data.content);
        post_html.find(".gp").text(post_data.gp);
        post_html.find(".bp").text(post_data.bp);
        jQuery("#content").append(post_html);       
    });
    jQuery(".edit.button").on("click", edit_post_handler);  
    jQuery(".delete.button").on("click", delete_post_handler);
    jQuery(".orange.button").on("click", evaluationgp_post_handler);
    jQuery(".black.button").on("click", evaluationbp_post_handler);
    jQuery(".green.button").on("click", release_post_handler);
    jQuery(".search.button").on("click", search_handler);

}

function get_template(template_name) {      
    return new Promise(function (resolve, reject) {
        const site_url = jQuery("meta#site_url").attr("content");
        jQuery.ajax({
            type: "GET",
            url: `${site_url}/Templates/${template_name}`,
            success: response => {
                resolve(response);
            },
            error: reject
        });
    });
}

function release_post_handler(event) { 
    let id = jQuery(event.target).parents("div.post").attr("id");
    let title = jQuery(`#${id}.post > .header > .title`).text();
    let content = jQuery(`#${id}.post > .body`).html();
    popup_window(id, title, true, content);
}

function edit_post_handler(event) {    
    let id = jQuery(event.target).parents("div.post").attr("id");
    let title = jQuery(`#${id}.post > .header > .title`).text();
    let content = jQuery(`#${id}.post > .body`).html();
    popup_window(id, title, false, content);
}


function delete_post_handler(event) {        
    let id = jQuery(event.target).parents("div.post").attr("id");
    let title = jQuery(`#${id}.post > .header > .title`).text();
    let content = jQuery(`#${id}.post > .body`).html();
    popup_delete_window(id, title, content);
}

function evaluationgp_post_handler(event) {       
    let id = jQuery(event.target).parents("div.post").attr("id");
    submit_evaluationgp_post(id);
}

function evaluationbp_post_handler(event) {      
    let id = jQuery(event.target).parents("div.post").attr("id");
    submit_evaluationbp_post(id);
}

function search_handler(event) {
    let match = jQuery("#search").val();
    submit_search(match);
}


function submit_release_handler() {  
    const site_url = jQuery("meta#site_url").attr("content");
    jQuery(".ui.form").ajaxSubmit({
        type: "POST",
        url: `${site_url}/Post/release_post`,
        success: function (success, statusText, xhr, element) {
            if (success == true) {
                post_get_all()
                swal("發文成功！", "你成功發出了文章", "success");
            } else {
                swal("發文失敗！", "發文時出了一點問題＞＜！", "error");
            }
        }
    });
}


function submit_edit_handler() {    
    const site_url = jQuery("meta#site_url").attr("content");
    jQuery(".ui.form").ajaxSubmit({
        type: "POST",
        url: `${site_url}/Post/update_post`,
        success: function (success, statusText, xhr, element) {
            let id = element.find("[name=id]").val();
            let content = element.find("[name=content]").val();
            if (success == true) {
                jQuery(`#${id}.post .body`).html(content);
                swal("編輯成功！", "你成功編輯了文章", "success");
            } else {
                swal("編輯失敗！", "編輯時出了一點問題＞＜！", "error");
            }
        }
    });
}

function submit_delete_handler() {  
    let modal = jQuery(".ui.modal");
    modal.modal('hide');
    const site_url = jQuery("meta#site_url").attr("content");
    jQuery(".ui.form").ajaxSubmit({
        type: "POST",
        url: `${site_url}/Post/delete_post`,
        success: function (success, statusText, xhr, element) {
            let id = element.find("[name=id]").val();
            if (success == true) {
                jQuery(`#${id}.post`).remove();
                swal("刪除成功！", "你成功刪除了文章", "success");
            } else {
                swal("刪除失敗！", "刪除時出了一點問題＞＜！", "error");
            }
        }
    });
}

function submit_evaluationgp_post(id) {    
    const site_url = jQuery("meta#site_url").attr("content");
    jQuery.ajax({
        type: "POST",
        data: {
            "id": id
        },
        url: `${site_url}/Post/evaluation_postgp`,
        success: function (success) {
            if (success == true) {
                swal("勇者獲得了1點能量");
            } else {
                swal("失敗了");
            }
        }
    })
}

function submit_evaluationbp_post(id) {       
    const site_url = jQuery("meta#site_url").attr("content");
    jQuery.ajax({
        type: "POST",
        data: {
            "id": id
        },
        url: `${site_url}/Post/evaluation_postbp`,
        success: function (success) {
            if (success == true) {
                swal("勇者削弱了1點精神");
            } else {
                swal("失敗了");
            }
        }
    })
}

function submit_search(match) {
    const site_url = jQuery("meta#site_url").attr("content");
    jQuery.ajax({
        type: "POST",
        data: {
            "match": match
        },
        url: `${site_url}/Post/search_post`,
        success: async function (article) {
            const posts = JSON.parse(article);
            const post_template = await get_template("post");
            jQuery("#content").empty();
            posts.forEach(post_data => {
                let post_html = jQuery(post_template);
                post_html.attr("id", post_data.id);
                post_html.find(".title").text(post_data.title);
                post_html.find(".author").text("匿名");
                post_html.find(".time").text(post_data.Upload_time);
                post_html.find(".time").attr("title", `最後更新時間：${post_data.Update_time}`);
                post_html.find(".body").html(post_data.content);
                post_html.find(".gp").text(post_data.gp);
                post_html.find(".bp").text(post_data.bp);
                jQuery("#content").append(post_html);
            });
        }
    })
}


function api_get_all_post() {
    return new Promise(function (resolve, reject) {
        var site_url = jQuery("meta#site_url").attr("content");
        jQuery.ajax({
            type: "GET",
            url: `${site_url}/Post/get_post`,
            success: function (response) {
                response = JSON.parse(response);
                resolve(response);
            },
            error: reject
        });
    });
}



function api_edit_post(id, content) {
    return new Promise(function (resolve, reject) {
        var site_url = jQuery("meta#site_url").attr("content");
        jQuery.ajax({
            type: "POST",
            url: `${site_url}/Post/update_post`,
            data: {
                id: id,
                content: content
            },
            success: function (response) {
                resolve(Boolean(response));
            },
            error: reject
        });
    });
}

function api_delete_post(id) {
    return new Promise(function (resolve, reject) {
        var site_url = jQuery("meta#site_url").attr("content");
        jQuery.ajax({
            type: "POST",
            url: `${site_url}/Post/delete_post`,
            data: {
                id: id,
            },
            success: function (response) {
                resolve(Boolean(response));
            },
            error: reject
        });
    });
}