<script>
    $(".js-upload-image").change(function (event) {
        makePreview(this);
        $("#upload-img-preview").show();
        $("#upload-img-delete").show();
    });

    function makePreview(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $("#upload-img-preview").attr("src", e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#upload-img-delete").click(function (event) {
        event.preventDefault();
        $("#upload-img-preview").attr("src", "").hide();
        $(".custom-file-input").val(null);
        $(this).hide();
    });

</script>
