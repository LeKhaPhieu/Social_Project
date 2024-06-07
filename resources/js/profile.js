$(document).ready(function () {
    const $btnSubmit = $(".btn-submit-profile");

    function toggleDisplay($element, displayValue) {
        if ($element) {
            $element.css("display", displayValue);
        }
    }

    function handleEditButton($btnEdit, $textElement, $inputElement) {
        $btnEdit.on("click", function () {
            toggleDisplay($textElement, "none");
            toggleDisplay($inputElement, "flex");
            toggleDisplay($btnSubmit, "block");
        });
    }

    const editElements = [
        {
            $btnEdit: $("#btnEditPhoneNumber"),
            $textElement: $(".phone-number-text"),
            $inputElement: $("#inputPhoneNumber")
        },
        {
            $btnEdit: $("#btnEditUserName"),
            $textElement: $(".user-name-text"),
            $inputElement: $("#inputUserName")
        },
        {
            $btnEdit: $("#btnEditGender"),
            $textElement: $(".gender-text"),
            $inputElement: $("#inputGender")
        },
        {
            $btnEdit: $("#btnEditAvatar"),
        }
    ];

    editElements.forEach(function (item) {
        handleEditButton(item.$btnEdit, item.$textElement, item.$inputElement);
    });
});

$(document).ready(function() {
    const btnChooseImage = $("#btnEditAvatar");
    const inputImage = $("#inputAvatar");
    const imagePreview = $("#profileAvatar");
    const errorElement = $('#imageAvatar');
    let currentImageSrc = imagePreview.attr('src');

    btnChooseImage.on("click", function() {
        inputImage.click();
    });

    inputImage.on("change", function() {
        const file = this.files[0];
        errorElement.text(''); 
        
        if (file) {
            const validExtensions = ['jpg', 'jpeg', 'png', 'gif', 'svg'];
            const fileExtension = file.name.split('.').pop().toLowerCase();
            
            if (!validExtensions.includes(fileExtension)) {
                errorElement.text('The file must have the extension jpeg, png, jpg, gif, or svg!!');
                $(this).val('');
                return;
            }

            if (file.size > 2048 * 1024) { 
                errorElement.text('The file must be less than 2048 KB in size!!');
                $(this).val('');
                return;
            }
            const reader = new FileReader();
            reader.onload = function(e) {
                const imageUrl = e.target.result;
                currentImageSrc = imageUrl;
                imagePreview.attr('src', imageUrl).show();
            };
            reader.readAsDataURL(file);
        } else {
            if (currentImageSrc) {
                imagePreview.attr('src', currentImageSrc).show();
            } else {
                imagePreview.hide();
            }
        }
    });
});
