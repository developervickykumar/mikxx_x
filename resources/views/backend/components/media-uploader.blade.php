@props(['inputId', 'categoryId', 'uploadUrl'])

<style>
    .media-file-box {
        margin-top: 10px;
        /*border: 1px solid #ccc;*/
        /*padding: 10px;*/
        border-radius: 6px;
        position: relative;
        display: flex;
    }

    .media-remove {
        position: absolute;
        top: 5px;
        right: 10px;
        color: red;
        cursor: pointer;
        font-size: 20px;
    }
    .form-control{
        border: 0;
        margin: 2px;
        background: #f2f2f2;
    }
</style>
<input type="file"
       id="{{ $inputId }}"
       class="form-control mb-2"
       data-upload-url="{{ $uploadUrl }}"
       multiple>


<div id="media-preview-{{ $inputId }}"></div>

<script>
   document.getElementById('{{ $inputId }}').addEventListener('change', function () {
    const files = this.files;
    const uploadUrl = this.dataset.uploadUrl;
    const previewWrapper = document.getElementById('media-preview-{{ $inputId }}');
let categoryId = document.getElementById('edit_category_id')?.value || '';


    Array.from(files).forEach(file => {
        const formData = new FormData();
        formData.append('media_file', file);
        formData.append('category_id', categoryId);
        formData.append('_token', '{{ csrf_token() }}');

        fetch(uploadUrl, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success && data.file_url) {
                const wrapper = document.createElement('div');
                wrapper.classList.add('media-file-box');
                wrapper.dataset.mediaId = data.media_id;

                wrapper.innerHTML = `
                    <span class="media-remove" onclick="removeMediaFile(this, ${data.media_id})">&times;</span>
                    <img src="${data.file_url}" alt="Uploaded" style="width: 60px; height: 60px; object-fit: cover;" class="mb-2">
                    <input type="hidden" name="category-media-id[]" value="${data.media_id}">
                    <input type="text" name="category-media-title-${data.media_id}" class="form-control mb-2" value="${file.name.split('.')[0]}">
                    <textarea name="category-media-description-${data.media_id}" class="form-control mb-2" placeholder="Description"></textarea>
                    <input type="text" name="category-media-keywords-${data.media_id}" class="form-control mb-2" placeholder="Keywords (comma separated)">
                `;
                previewWrapper.appendChild(wrapper);
            }
        });
    });
});

    function removeMediaFile(el, mediaId) {
        if (!confirm('Are you sure to delete this file?')) return;

        fetch(`/admin/delete-category-media/${mediaId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        }).then(response => response.json())
        .then(data => {
            if (data.success) {
                el.closest('.media-file-box').remove();
            }
        });
    }
</script>
