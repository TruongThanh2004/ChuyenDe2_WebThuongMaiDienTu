const originalImageSrc = document.getElementById('user-image').src;

                     
document.querySelector('.account-settings-fileinput').addEventListener('change', function (event) {
    const file = event.target.files[0]; 
    if (file) {
        const reader = new FileReader();

        reader.onload = function (e) {
       
            document.getElementById('user-image').src = e.target.result;
        };

     
        reader.readAsDataURL(file);
    }
});


document.getElementById('reset-button').addEventListener('click', function () {

    document.getElementById('user-image').src = originalImageSrc;


    document.querySelector('.account-settings-fileinput').value = '';
});