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
        }
    ];

    editElements.forEach(function (item) {
        handleEditButton(item.$btnEdit, item.$textElement, item.$inputElement);
    });

    const $avatarEdit = $('.avatar-edit');
    const $avatarInput = $('.avatar-input');
    const $avatarImage = $('.profile-avatar');

    if ($avatarEdit.length) {
        $avatarEdit.on('click', function () {
            $avatarInput.click();
            toggleDisplay($btnSubmit, "block");
        });
    }

    if ($avatarInput.length) {
        $avatarInput.on('change', function () {
            const file = $avatarInput[0].files[0];
            const reader = new FileReader();
            reader.onloadend = function () {
                $avatarImage.attr("src", reader.result);
            }
            if (file) {
                reader.readAsDataURL(file);
            } else {
                $avatarImage.attr("src", "");
            }
        });
    }
});
