@props(['inputId', 'imageUrl' => asset('images/no-img.jpg'), 'categoryId'])

<style>
    .image-uploader-wrapper {
        cursor: pointer;
        display: inline-block;
    }

    .image-uploader-wrapper img {
        width: 30px;
        height: 30px;
        object-fit: cover;
        border-radius: 6px;
    }

    .image-hidden-input {
        display: none;
    }
</style>

<div class="image-uploader-wrapper">
    <label for="{{ $inputId }}">
        <img id="preview-{{ $inputId }}" src="{{ $imageUrl }}" alt="Category Image">
    </label>
    <input type="file" id="{{ $inputId }}" class="image-hidden-input category-image-input" data-category-id="{{ $categoryId }}">
</div>
