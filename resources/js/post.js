$(document).ready(function() {
    const btnChooseImage = $("#btnImage");
    const inputImage = $("#inputImage");
    const imagePreview = $("#imagePreview");
    const errorElement = $('#imageError');
    let currentImage = null;
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
                errorElement.text('The file must have the extension jpeg, png, jpg, gif or svg!!');
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
                currentImage = `<img src="${imageUrl}" alt="Image Preview">`;
                imagePreview.html(currentImage);
                imagePreview.css("display", "block");
            };
            reader.readAsDataURL(file);
        } else {
            if (currentImage) {
                imagePreview.html(currentImage);
                imagePreview.css("display", "block");
            } else {
                imagePreview.html("");
                imagePreview.css("display", "none");
            }
        }
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const checkList = document.getElementById('list1');
    if (!checkList) return;
    const anchor = checkList.querySelector('.anchor');
    const items = checkList.querySelector('.items');
    const checkboxes = items.querySelectorAll('input[type="checkbox"]');
    function updateAnchor() {
        const selectedCategories = [];
        checkboxes.forEach(checkbox => {
            if (checkbox.checked) {
                const label = checkbox.parentElement.textContent.trim();
                selectedCategories.push(label);
            }
        });
        if (selectedCategories.length > 0) {
            anchor.textContent = selectedCategories.join(', ');
        } else {
            anchor.textContent = "Select Category";
        }
    }
    updateAnchor();
    anchor.addEventListener('click', function() {
        checkList.classList.toggle('visible');
    });
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateAnchor);
    });
    document.addEventListener('click', function(event) {
        if (!checkList.contains(event.target)) {
            checkList.classList.remove('visible');
        }
    });
});
