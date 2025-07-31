<div class="setting-block functionality-settings" data-type="subcategory" style="display: none;">
    <!-- 📌 Functionality Selection Radio Buttons -->
    <div class="mb-4">
        <label class="form-label">Select Functionality</label>
        <div id="functionalityRadios" class="d-flex flex-wrap gap-3">
            <label><input type="radio" name="functionality" value="dropdowns">
                Dropdowns</label>
            <label><input type="radio" name="functionality" value="communication">
                Communication</label>
            <!-- Add more cases here -->
        </div>
    </div>

    <!-- 📌 Content Target Area -->
    <div id="functionalityContainer"></div>

    <!-- ✅ Script -->
    <script>
    document.querySelectorAll('input[name="functionality"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const selected = this.value;
            const container = document.getElementById(
                'functionalityContainer');

            switch (selected) {

                case 'dropdowns':
                    container.innerHTML = `
    <div class="mb-3">
      <label class="form-label">Select Dropdown Type</label>
      <div class="d-flex flex-wrap gap-2">
        ${[
          'Dropdown',
          'Checkbox Group',
          'Radio Button',
          'Toggle Switch',
          'Button Group',
          'Multiselect Dropdown',
          'Checkbox Dropdown',
          'Chip View Dropdown',
          'Expandable Dropdown',
          'Grouped Dropdown',
          'Dropdown with Search'
        ].map((type, i) => `
          <label class="me-3">
            <input type="radio" name="dropdownType" value="${type}" ${i === 0 ? 'checked' : ''}>
            ${type}
          </label>
        `).join('')}
      </div>
    </div>

    <div class="row g-3">
      <div class="col-md-6">
        <label class="form-label">Option Text</label>
        <input type="text" id="optionText" class="form-control" placeholder="e.g., Option A">
      </div>
      <div class="col-md-3">
        <label class="form-label">Icon Class (optional)</label>
        <input type="text" id="optionIcon" class="form-control" placeholder="e.g., fa fa-user">
      </div>
      <div class="col-md-3">
        <label class="form-label">Image URL (optional)</label>
        <input type="url" id="optionImage" class="form-control" placeholder="Image URL">
      </div>
    </div>

    <div class="mt-3">
      <label class="form-label">Selection Mode</label>
      <div>
        <label><input type="radio" name="selectMode" value="single" checked> Single Select</label>
        <label class="ms-3"><input type="radio" name="selectMode" value="multiple"> Multiple Select</label>
      </div>
    </div>

    <button class="btn btn-sm btn-primary mt-3" id="addDropdownOption">Add Option</button>

    <div class="mt-4">
      <label class="form-label">Preview</label>
      <div id="dropdownPreview" class="border rounded p-3 bg-light"></div>
    </div>
  `;

                    setTimeout(() => {
                        const preview = document.getElementById(
                            'dropdownPreview');
                        const options = [];

                        const renderPreview = () => {
                            const type = document.querySelector(
                                'input[name="dropdownType"]:checked'
                            )?.value;
                            const mode = document.querySelector(
                                'input[name="selectMode"]:checked'
                            )?.value;

                            preview.innerHTML = ''; // reset

                            if (options.length === 0) {
                                preview.innerHTML =
                                    `<em>No options added yet</em>`;
                                return;
                            }

                            const iconAndImage = (opt) => {
                                const icon = opt.icon ?
                                    `<i class="${opt.icon} me-1"></i>` :
                                    '';
                                const img = opt.image ?
                                    `<img src="${opt.image}" style="width:20px;height:20px;object-fit:cover;margin-right:5px;border-radius:4px;">` :
                                    '';
                                return `${img}${icon}<span>${opt.label}</span>`;
                            };

                            switch (type) {
                                case 'Dropdown':
                                case 'Dropdown with Search':
                                    const isMulti = mode ===
                                        'multiple';
                                    preview.innerHTML = `
            <select class="form-select" ${isMulti ? 'multiple' : ''}>
              ${options.map(opt => `<option>${opt.label}</option>`).join('')}
            </select>
          `;
                                    break;

                                case 'Radio Button':
                                    preview.innerHTML = options
                                        .map(opt => `
            <label class="d-block">
              <input type="radio" name="previewRadio"> ${iconAndImage(opt)}
            </label>
          `).join('');
                                    break;

                                case 'Checkbox Group':
                                    preview.innerHTML = options
                                        .map(opt => `
            <label class="d-block">
              <input type="checkbox"> ${iconAndImage(opt)}
            </label>
          `).join('');
                                    break;

                                case 'Toggle Switch':
                                    preview.innerHTML = options
                                        .map((opt, i) => `
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" id="toggle_${i}">
              <label class="form-check-label" for="toggle_${i}">${iconAndImage(opt)}</label>
            </div>
          `).join('');
                                    break;

                                case 'Button Group':
                                    preview.innerHTML = `
            <div class="btn-group" role="group">
              ${options.map(opt => `<button type="button" class="btn btn-outline-primary">${opt.label}</button>`).join('')}
            </div>
          `;
                                    break;

                                default:
                                    // Default visual for custom types like Chip View, Expandable, etc.
                                    preview.innerHTML = options
                                        .map(opt => `
            <div class="badge bg-secondary me-2 mb-2 p-2">
              ${iconAndImage(opt)}
            </div>
          `).join('');
                            }
                        };

                        document.getElementById('addDropdownOption')
                            .addEventListener('click', () => {
                                const text = document
                                    .getElementById(
                                        'optionText').value
                                    .trim();
                                const icon = document
                                    .getElementById(
                                        'optionIcon').value
                                    .trim();
                                const image = document
                                    .getElementById(
                                        'optionImage').value
                                    .trim();

                                if (!text) return alert(
                                    'Enter option text');
                                options.push({
                                    label: text,
                                    icon,
                                    image
                                });

                                // Reset inputs
                                document.getElementById(
                                    'optionText').value = '';
                                document.getElementById(
                                    'optionIcon').value = '';
                                document.getElementById(
                                        'optionImage').value =
                                    '';

                                renderPreview();
                            });

                        document.querySelectorAll(
                            'input[name="dropdownType"], input[name="selectMode"]'
                        ).forEach(input => {
                            input.addEventListener('change',
                                renderPreview);
                        });

                    }, 100);
                    break;


                case 'communication':
                    container.innerHTML =
                        `<div class="alert alert-info">Communication functionality selected (load from communication case)</div>`;
                    break;

                default:
                    container.innerHTML =
                        `<div class="alert alert-warning">No case implemented</div>`;
            }
        });
    });
    </script>

</div>