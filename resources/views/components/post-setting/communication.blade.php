  <!-- Communication Tab -->
  <div class="setting-block functionality-settings" data-type="communication" style="display: none;">


      <h5 class="mb-3">Communication Conditions</h5>

      <div class="form-check">
          <input class="form-check-input comm-check" type="checkbox" value="email" id="emailCheck">
          <label class="form-check-label" for="emailCheck">Email ID</label>
      </div>

      <div class="form-check">
          <input class="form-check-input comm-check" type="checkbox" value="contact" id="contactCheck">
          <label class="form-check-label" for="contactCheck">Contact Number (with Country
              Code)</label>
      </div>

      <div class="form-check">
          <input class="form-check-input comm-check" type="checkbox" value="whatsapp" id="whatsappCheck">
          <label class="form-check-label" for="whatsappCheck">WhatsApp Number (Same as Contact
              or Alternative)</label>
      </div>

      <div class="form-check">
          <input class="form-check-input comm-check" type="checkbox" value="social" id="socialCheck">
          <label class="form-check-label" for="socialCheck">Social Media Links</label>
      </div>

      <div id="commFields" class="row mt-3"></div>

      <script>
      const fieldContainer = document.getElementById('commFields');

      const commMap = {
          email: `
            <div id="commField_email" class="col-md-6 mb-3">
                <label>Email</label>
                <input type="email" id="commEmail" name="communication[email]" class="form-control" placeholder="Enter valid email">
                <small id="emailStatus" class="text-muted"></small>
            </div>
        `,
          contact: `
            <div id="commField_contact" class="col-md-6 mb-3">
                <label>Contact Number</label>
                <input type="tel" id="commContact" name="communication[contact]" class="form-control" placeholder="+91XXXXXXXXXX">
                <small id="contactStatus" class="text-muted"></small>
            </div>
        `,
          whatsapp: `
            <div id="commField_whatsapp" class="col-md-6 mb-3">
                <label>WhatsApp Number</label>
                <input type="tel" id="commWhatsapp" name="communication[whatsapp]" class="form-control" placeholder="+91XXXXXXXXXX">
                <small id="whatsappStatus" class="text-muted"></small>
                <div class="form-check mt-2">
                    <input class="form-check-input" type="checkbox" id="sameAsContact">
                    <label class="form-check-label" for="sameAsContact">Same as Contact</label>
                </div>
            </div>
        `,
          social: `
            <div id="commField_social" class="col-md-12 mb-3">
                <label>Social Media Links</label>
                <div class="row">
                    <div class="col-md-6 mb-2 d-flex align-items-center">
                        <i class="fab fa-facebook fa-lg me-2 text-primary"></i>
                        <input class="form-control social-input" data-platform="facebook" name="communication[social][]" type="url" placeholder="Facebook URL">
                    </div>
                    <div class="col-md-6 mb-2 d-flex align-items-center">
                        <i class="fab fa-instagram fa-lg me-2 text-danger"></i>
                        <input class="form-control social-input" data-platform="instagram" name="communication[social][]" type="url" placeholder="Instagram URL">
                    </div>
                    <div class="col-md-6 mb-2 d-flex align-items-center">
                        <i class="fab fa-linkedin fa-lg me-2 text-primary"></i>
                        <input class="form-control social-input" data-platform="linkedin" name="communication[social][]" type="url" placeholder="LinkedIn URL">
                    </div>
                    <div class="col-md-6 mb-2 d-flex align-items-center">
                        <i class="fab fa-twitter fa-lg me-2 text-primary"></i>
                        <input class="form-control social-input" data-platform="x" name="communication[social][]" type="url" placeholder="X (Twitter) URL">
                    </div>
                    <div class="col-md-6 mb-2 d-flex align-items-center">
                        <i class="fab fa-youtube fa-lg me-2 text-danger"></i>
                        <input class="form-control social-input" data-platform="youtube" name="communication[social][]" type="url" placeholder="YouTube URL">
                    </div>
                    <div class="col-md-6 mb-2 d-flex align-items-center">
                        <i class="fab fa-google fa-lg me-2 text-danger"></i>
                        <input class="form-control social-input" data-platform="google" name="communication[social][]" type="url" placeholder="Google Profile URL">
                    </div>
                </div>

                <hr class="my-3">
                <label>Add Custom Social Link</label>
                <div class="d-flex gap-2 align-items-center mb-2">
                    <select class="form-control w-25 social-select">
                        <option value="other">Other</option>
                        <option value="facebook">Facebook</option>
                        <option value="instagram">Instagram</option>
                        <option value="linkedin">LinkedIn</option>
                        <option value="x">X (Twitter)</option>
                        <option value="youtube">YouTube</option>
                        <option value="google">Google</option>
                    </select>
                    <input class="form-control w-75 social-input" data-custom="true" type="url" name="communication[social][]" placeholder="Enter Social Link">
                    <small class="form-text status-text w-100"></small>
                </div>
            </div>
        `


      };

      document.querySelectorAll('.comm-check').forEach(chk => {
          chk.addEventListener('change', () => {
              const fieldId = `commField_${chk.value}`;
              const exists = document.getElementById(fieldId);

              if (chk.checked && !exists) {
                  const wrapper = document.createElement('div');
                  wrapper.innerHTML = commMap[chk.value];
                  fieldContainer.appendChild(wrapper);

                  setTimeout(() => {
                      const emailInput = document.getElementById(
                          'commEmail');
                      const contactInput = document.getElementById(
                          'commContact');
                      const whatsappInput = document.getElementById(
                          'commWhatsapp');
                      const sameAsContact = document.getElementById(
                          'sameAsContact');

                      if (emailInput) {
                          emailInput.addEventListener('input',
                              function() {
                                  const email = this.value.trim();
                                  const status = document
                                      .getElementById(
                                          'emailStatus');
                                  const valid =
                                      /^[^@\s]+@[^@\s]+\.[^@\s]+$/
                                      .test(email);

                                  status.textContent = email ? (
                                      valid ? "Valid Email" :
                                      "Invalid Email") : "";
                                  status.className = valid ?
                                      "text-success" :
                                      "text-danger";
                              });
                      }

                      if (contactInput) {
                          contactInput.addEventListener('input',
                              function() {
                                  const contact = this.value
                                      .trim();
                                  const status = document
                                      .getElementById(
                                          'contactStatus');
                                  const valid =
                                      /^(\+?\d{1,4})?\d{7,14}$/
                                      .test(contact);

                                  status.textContent = contact ? (
                                      valid ? "Valid Number" :
                                      "Invalid Number") : "";
                                  status.className = valid ?
                                      "text-success" :
                                      "text-danger";
                              });
                      }

                      if (whatsappInput) {
                          whatsappInput.addEventListener('input',
                              function() {
                                  const whatsapp = this.value
                                      .trim();
                                  const status = document
                                      .getElementById(
                                          'whatsappStatus');
                                  const valid =
                                      /^(\+?\d{1,4})?\d{7,14}$/
                                      .test(whatsapp);

                                  status.textContent = whatsapp ?
                                      (valid ? "Valid Number" :
                                          "Invalid Number") : "";
                                  status.className = valid ?
                                      "text-success" :
                                      "text-danger";
                              });
                      }

                      if (sameAsContact && whatsappInput &&
                          contactInput) {
                          sameAsContact.addEventListener('change',
                              function() {
                                  if (this.checked) {
                                      whatsappInput.value =
                                          contactInput.value;
                                      whatsappInput.dispatchEvent(
                                          new Event('input'));
                                  }
                              });
                      }



                      // Social media platform validation map
                      const socialPatterns = {
                          facebook: /^(https?:\/\/)?(www\.)?facebook\.com\/[A-Za-z0-9_.-]+$/i,
                          instagram: /^(https?:\/\/)?(www\.)?instagram\.com\/[A-Za-z0-9_.-]+$/i,
                          linkedin: /^(https?:\/\/)?(www\.)?linkedin\.com\/in\/[A-Za-z0-9_.-]+$/i,
                          x: /^(https?:\/\/)?(www\.)?(x\.com|twitter\.com)\/[A-Za-z0-9_.-]+$/i,
                          youtube: /^(https?:\/\/)?(www\.)?youtube\.com\/(c|channel|user)\/[A-Za-z0-9_.-]+$/i,
                          google: /^(https?:\/\/)?(www\.)?plus\.google\.com\/[A-Za-z0-9_.-]+$/i, // or use custom G Profiles
                          other: /^(https?:\/\/)?([\w\d\-]+\.)+\w{2,}(\/[^\s]*)?$/i
                      };


                      // Validate fixed platform inputs
                      document.querySelectorAll(
                          '.social-input[data-platform]').forEach(
                          input => {
                              const platform = input.dataset
                                  .platform;
                              input.addEventListener('input',
                                  () => {
                                      const pattern =
                                          socialPatterns[
                                              platform];
                                      const valid = pattern
                                          .test(input.value
                                              .trim());
                                      input.classList.remove(
                                          'is-invalid',
                                          'is-valid');
                                      input.classList.add(
                                          valid ?
                                          'is-valid' :
                                          'is-invalid');
                                  });
                          });

                      // Validate custom platform + input pair
                      document.querySelectorAll('.social-select')
                          .forEach(select => {
                              const input = select
                                  .nextElementSibling;
                              const status = input
                                  .nextElementSibling;

                              function validate() {
                                  const platform = select.value;
                                  const value = input.value
                                      .trim();
                                  const pattern = socialPatterns[
                                          platform] ||
                                      socialPatterns.other;
                                  const valid = pattern.test(
                                      value);
                                  input.classList.remove(
                                      'is-invalid', 'is-valid'
                                  );
                                  input.classList.add(valid ?
                                      'is-valid' :
                                      'is-invalid');
                                  status.textContent = value ? (
                                      valid ? 'Valid URL' :
                                      'Invalid URL') : '';
                                  status.className =
                                      `form-text status-text ${valid ? 'text-success' : 'text-danger'}`;
                              }

                              select.addEventListener('change',
                                  validate);
                              input.addEventListener('input',
                                  validate);
                          });


                  }, 50);
              } else if (!chk.checked && exists) {
                  exists.remove();


              } else if (!chk.checked && exists) {
                  exists.remove();
              }
          });
      });
      </script>
  </div>