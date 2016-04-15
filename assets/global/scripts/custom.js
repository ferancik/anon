

//function getNewSubmission(url) {
//    var submission_count = parseInt($("#count_submission").val());
//    $.ajax({
//        url: url,
//        data: 'submission_count=' + submission_count,
//        type: 'post',
//        dataType: 'json',
//        success: function (json) {
//            
//            $("#count_submission").val(json.submission_count);
//            $("#new-form").before(json.new_submission);
//        }
//    });
//}


function getNewSubmission(url) {

    if ($("#form_registration").valid()) {
        $.ajax({
            url: url,
            data: $('#form_registration').serialize(),
            type: 'post',
            dataType: 'json',
            success: function (json) {
                $('#count_submission').val(json.count_submission);
            },
            complete: function (jqXHR, textStatus) {
                clearFormRegistration();
                updateListSubmission();
                hideLoader();
                $("#save-update-submission").addClass("hide");
                $("#more_submission").removeClass("hide");
            },
            beforeSend: function (xhr) {
                showLoader();
            }
        });
    }
}


function showLoader(){
    $(".loader").removeClass("hide");
}


function hideLoader(){
    $(".loader").addClass("hide");
}

function updateSubmission(url, submission_hash) {
    $.ajax({
        url: url,
        data: {submission_hash: submission_hash},
        type: 'post',
        dataType: 'json',
        success: function (json) {
            $("#registration-form").html(json.html);
        },
        complete: function (jqXHR, textStatus) {
            hideLoader();
            $("#save-update-submission").removeClass('hide');
            $("#more_submission").addClass('hide');
        },
        beforeSend: function (xhr) {
            showLoader();
        }
    });
}


function deleteSubmission(url, submission_hash) {
    $.ajax({
        url: url,
        data: {submission_hash: submission_hash},
        type: 'post',
        dataType: 'json',
        success: function (json) {

        },
        complete: function (jqXHR, textStatus) {
            updateListSubmission();
            hideLoader();
        },
        beforeSend: function (xhr) {
            showLoader();
        }
    });
}


function updateListSubmission() {
    $.ajax({
        url: '/en/event/getSubmissionList',
        type: 'post',
        data: {event_id : $('#event_id').val()},
        dataType: 'json',
        success: function (json) {
            $("#submission-list").html("");
            $("#submission-list").html(json.html);
        }
    });
}

function clearFormRegistration() {

    $(".form-body")
            .find("input[type=text], input[type=hidden], input[type=email],textarea,select")
            .val('')
            .end()
            .find("input[type=checkbox], input[type=radio]")
            .prop("checked", "")
            .end();
    
    $(".checked").removeClass('checked');
}


