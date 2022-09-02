require(['jquery'],function($){
    $(document).ready(function(){
//Clicking the GIFT button
$(".personalize-gift-btn").click(function () {

    navigator.mediaDevices.getUserMedia({
        audio: true,
        video: true
    })
        .then(function (stream) {
            try {
                liveStream = stream;
                recorder = new MediaRecorder(liveStream);
                $('.record-column').css('display', 'block'); //Record button is hidden by default
                stream.getTracks().forEach(function (track) {
                    track.stop();
                });
            } catch (error) {
                updateRecordButtonText();
            }
        });
});

function updateRecordButtonText() {
    $(".emocomm-upload-span").text('Record / Upload');
}


recordButton = document.getElementById('record');
stopButton = document.getElementById('stop');
recordButton.addEventListener('click', startRecording);
stopButton.addEventListener('click', stopRecording);

function startRecording() {

    // get video & audio stream from user
    navigator.mediaDevices.getUserMedia({
        audio: true,
        video: true
    })
        .then(function (stream) {
            liveStream = stream;

            var liveVideo = document.getElementById('live');
            // liveVideo.src = URL.createObjectURL(stream);
            // liveVideo.play();
            liveVideo.srcObject = stream;
            liveVideo.play();
            ``

            recorder = new MediaRecorder(liveStream);
            if (recorder != undefined) {
                recorder.addEventListener('dataavailable', onRecordingReady);
            }

            $(".video_display").hide();
            $("#popup_image").hide();
            $(".live_video").show();
            $("#upload-file-btn").hide();
            $("#record").hide();
            $("#stop").css('display', 'flex');
            recorder.start();
        });

}

function stopRecording() {

    // Stopping the recorder will eventually trigger the 'dataavailable' event and we can complete the recording process
    recorder.stop();
    $("#record").css('display', 'flex');
    $("#stop").hide();
    $('#remove-recorded-video-btn').css('display', 'flex');
    $('#upload-file-btn').hide();
    liveStream.getTracks().forEach(function (track) {
        track.stop();
    });
}

function onRecordingReady(e) {
    var video = document.getElementById('recording');
    // e.data contains a blob representing the recording
    video.src = URL.createObjectURL(e.data);
    video.play();
    $(".video_display").show();
    $(".live_video").hide();
    blob_data = e.data;
}


//When user selects a file
$(document).on('input', '#selectedFile', function () {
    file_error = null;
    if ($('#selectedFile').prop('files').length > 0) {
        $("#record").hide();
        $("#stop").hide();
        $('#remove-recorded-video-btn').hide();
        $('#remove-selected-video-btn').css('display', 'flex');

        var selected_file = $('#selectedFile').prop('files')[0];
        if (selected_file.size > max_file_size) {
            if (file_error === null) {
                file_error = "";
            }
            file_error += "Your file is larger than " + max_file_size / 1000000 + " MB!<br/>";
            $("#selectedFileError").html("Your file is larger than " + max_file_size / 1000000 + " MB!");
        }
        var parts = selected_file.name.split('.');
        var file_format = parts[parts.length - 1];
        if (!accepted_file_types.includes(file_format.toLowerCase())) {
            if (file_error === null) {
                file_error = "";
            }
            file_error += "Unsupported format! (supported formats: " + accepted_file_types.toString() + ")";
        }
        if (file_error == null) {
            $("#selectedFileError").hide();
        } else {
            $("#selectedFileError").html(file_error).show();
        }
        $("#selectedFileName").html(selected_file.name);
        $('#selectedFileName').show();
    } else {
        $("#selectedFileName").html("");
        $('#selectedFileName').hide();
        $("#record").css('display', 'flex');
        $('#remove-selected-video-btn').hide();
    }
});

//When user submits the selected file
$(document).on('click', '#file-upload', function () {
        if ((file_error == null && $('#selectedFile').prop('files').length > 0) || ($('#recording').attr('src') !== undefined)) {
            $("#uploading-fa").show();
            $("#file-upload").prop('disabled', true);
            var form_data = new FormData();
            if ($('#recording').attr('src') !== undefined) {
                form_data.append('file', blob_data, 'file.mkv');
            } else {
                form_data.append('file', $('#selectedFile')[0].files[0]);
            }
            //SEND THE FILE IN AJAX
        } else {
            $("#uploading-fa").hide();
        }
    }
   );
  });
});