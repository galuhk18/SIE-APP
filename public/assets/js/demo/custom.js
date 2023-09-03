function readURL(input) {
    if (input.files && input.files[0]) {
        let reader = new FileReader();
        reader.onload = function(e) {
            $('#img-preview').attr('src', e.target.result);
            $('#img-preview').attr('height','150px');
        }
        reader.readAsDataURL(input.files[0]);
    }
}

if($('#img-preview').attr('src')) {

    $('#img-preview').show();
} else {

    $('#img-preview').hide();
}


 $("#form-file").change(function() {
    $('#img-preview').show();
     readURL(this);
     let nameFile = $(this).val();
     $(".custom-file-label").html(nameFile);
});

$('body').on('click', '.delete-confirm', function (event) {
    event.preventDefault();
    const url = $(this).attr('href');

    Swal.fire({
        title: 'Are you sure?',
        text: "Delete this data",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes'
      }).then((result) => {
        if (result.value) {
            window.location.href = url;
        }
      })
});

$('.count').each(function () {
    $(this).prop('Counter',0).animate({
        Counter: $(this).text()
    }, {
        duration: 1000,
        easing: 'swing',
        step: function (now) {
            $(this).text(Math.ceil(now));
        }
    });
});
