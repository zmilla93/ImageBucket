let imageRotation = 0;
let previewImage;
let imageWrapper;
let uploadButton;
let uploadForm;
let uploadPreview;
let uploadErrorElement;
let fileInput;
let uploadError = false;

function init() {
    // Grab references used in functions
    uploadPreview = document.getElementById("upload-preview-image");
    uploadPreviewWrapper = document.getElementById("upload-preview-image-wrapper");
    fileInput = document.getElementById("fileInput");
    uploadButton = document.getElementById("upload-submit-button")
    uploadErrorElement = document.getElementById("image-upload-error");
    uploadForm = document.getElementById("image-upload-form");
    fileInput.onchange = updatePreviewImage;

    // Add drag/drop functionality
    let dropArea = document.getElementById("upload-drop-area");
    dropArea.ondragover = dropArea.ondragenter = function (evt) { evt.preventDefault(); }
    dropArea.ondrop = function (evt) {
        evt.preventDefault();
        fileInput.files = evt.dataTransfer.files;
        updatePreviewImage();
    }
    uploadForm.onsubmit = validateFileUpload;
}

function updatePreviewImage() {
    const file = fileInput.files[fileInput.files.length - 1];
    if (file) {
        uploadPreview.src = URL.createObjectURL(file);
        uploadPreviewWrapper.classList.add("margin-top");
    } else {
        uploadPreviewWrapper.classList.remove("margin-top");
        uploadPreview.src = "";
    }
    setUploadError();
}

function setUploadError(error = null) {
    uploadErrorElement.innerHTML = error;
}

function showUploadPopupIfError() {
    if (uploadError) showUploadPopup();
}

function validateFileUpload() {
    // Ensure there is a file to be uploaded
    if (fileInput.files.length == 0) {
        setUploadError("No file selected.");
        return false;
    }
    // Check the size of the file
    const file = fileInput.files[fileInput.files.length - 1];
    const size = file.size;
    if (size > 1000000 * 4) {
        setUploadError("Image is too large! Max size 4MB.");
        return false;
    }
    uploadButton.disabled = true;
    return true;
}

document.addEventListener("DOMContentLoaded", init);
document.addEventListener("DOMContentLoaded", showUploadPopupIfError);