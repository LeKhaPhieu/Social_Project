const btnChooseImage = document.getElementById("btnImage")
const inputImage = document.getElementById("inputImage")
const imagePreview = document.getElementById("imagePreview")

let currentImage = null

btnChooseImage.addEventListener("click", function () {
    inputImage.click()
})

inputImage.addEventListener("change", function () {
    const selectedFileName = inputImage.value.split('\\').pop()

    if (selectedFileName) {
        const file = inputImage.files[0]

        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader()

            reader.onload = function (e) {
                const imageUrl = e.target.result
                currentImage = `<img src="${imageUrl}" alt="Image Preview">`
                imagePreview.innerHTML = currentImage
                imagePreview.style.display = 'block'
            }

            reader.readAsDataURL(file)
        }
    } else {
        if (currentImage) {
            imagePreview.innerHTML = currentImage
            imagePreview.style.display = 'block'
        } else {
            imagePreview.innerHTML = ""
            imagePreview.style.display = 'none'
        }
    }
})
