<div class="setting-block functionality-settings" data-type="user" style="display: none;">

    <h5 class="mb-3">User Conditions</h5>

    <!-- Static Conditions -->
    <div class="mb-3">
        <label class="form-check-label fw-semibold d-block">Select User Options:</label>
        <div class="form-check form-check-inline">
            <input class="form-check-input user-field-toggle" type="checkbox" value="profile_pic" id="profilePic">
            <label class="form-check-label" for="profilePic">Profile Picture</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input user-field-toggle" type="checkbox" value="title" id="userTitle">
            <label class="form-check-label" for="userTitle">Title</label>
        </div>
    </div>

    <!-- Name Type -->
    <div class="mb-3">
        <label class="form-label fw-semibold">Name Format:</label><br>
        <div class="form-check form-check-inline">
            <input class="form-check-input name-format" type="radio" name="nameFormat" id="firstLast" value="first_last"
                checked>
            <label class="form-check-label" for="firstLast">First & Last Name</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input name-format" type="radio" name="nameFormat" id="fullName" value="full">
            <label class="form-check-label" for="fullName">Full Name</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input name-format" type="radio" name="nameFormat" id="middleName"
                value="with_middle">
            <label class="form-check-label" for="middleName">Add Middle Name</label>
        </div>
    </div>

    <!-- Dynamic Fields Container -->
    <div class="row g-3 align-items-end" id="userFieldsRow"></div>
</div>



<script>
document.addEventListener('DOMContentLoaded', () => {
    const userFieldsRow = document.getElementById('userFieldsRow');

    const renderUserFields = () => {
        userFieldsRow.innerHTML = '';

        // Checkboxes
        if (document.getElementById('profilePic').checked) {
            userFieldsRow.innerHTML += `
                                                    <div class="col-md-1">
                                                    
                                                    <div class="image-uploader-wrapper mb-2">
                                                        <label for="profilePicInput">
                                                            <img id="" src="{{asset('images/no-img.jpg') }}" alt="profile Image" height="30px" width="30px">
                                                        </label>
                                                        <input type="file" id="" class="image-hidden-input" ">
                                                    </div>
                                                    </div>`;
        }

        if (document.getElementById('userTitle').checked) {
            userFieldsRow.innerHTML += `
                                                    <div class="col-md-2">
                                                    <label class="form-label">Title</label>
                                                    <select class="form-select mb-2">
                                                        <option>Mr.</option><option>Mrs.</option><option>Miss</option>
                                                    </select>
                                                    </div>`;
        }

        // Radio - Name Formats
        const selectedName = document.querySelector('.name-format:checked')
            ?.value;

        if (selectedName === 'first_last') {
            userFieldsRow.innerHTML += `
                                                    <div class="col-md-3">
                                                    <label class="form-label">First Name</label>
                                                    <input type="text" class="form-control">
                                                    </div>
                                                    <div class="col-md-3">
                                                    <label class="form-label">Last Name</label>
                                                    <input type="text" class="form-control">
                                                    </div>`;
        } else if (selectedName === 'full') {
            userFieldsRow.innerHTML += `
                                                    <div class="col-md-6">
                                                    <label class="form-label">Full Name</label>
                                                    <input type="text" class="form-control">
                                                    </div>`;
        } else if (selectedName === 'with_middle') {
            userFieldsRow.innerHTML += `
                                                    <div class="col-md-3">
                                                    <label class="form-label">First Name</label>
                                                    <input type="text" class="form-control">
                                                    </div>
                                                    <div class="col-md-3">
                                                    <label class="form-label">Middle Name</label>
                                                    <input type="text" class="form-control">
                                                    </div>
                                                    <div class="col-md-3">
                                                    <label class="form-label">Last Name</label>
                                                    <input type="text" class="form-control">
                                                    </div>`;
        }
    };

    document.querySelectorAll('.user-field-toggle, .name-format').forEach(
        el => {
            el.addEventListener('change', renderUserFields);
        });

    renderUserFields(); // Initial call
});
</script>