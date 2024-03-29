const chooseGender = document.querySelectorAll('.gender-choose');
chooseGender.forEach(function (checkbox) {
    checkbox.addEventListener('change', function () {
        if (this.checked) {
            chooseGender.forEach(function (otherCheckbox) {
                if (otherCheckbox !== checkbox) {
                    otherCheckbox.checked = false;
                }
            });
        }
    });
});
