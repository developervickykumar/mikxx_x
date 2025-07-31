@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">
                    Documentation
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <a href="#overview" class="list-group-item list-group-item-action">Overview</a>
                        <a href="#field-types" class="list-group-item list-group-item-action">Field Types</a>
                        <a href="#creating-fields" class="list-group-item list-group-item-action">Creating Field Types</a>
                        <a href="#validation" class="list-group-item list-group-item-action">Validation Rules</a>
                        <a href="#components" class="list-group-item list-group-item-action">Component Reference</a>
                        <a href="#json-schema" class="list-group-item list-group-item-action">JSON Schema</a>
                        <a href="#dependencies" class="list-group-item list-group-item-action">Field Dependencies</a>
                        <a href="#examples" class="list-group-item list-group-item-action">Examples</a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-9">
            <div class="card">
                <div class="card-header">
                    <h2 class="mb-0">Field Types Documentation</h2>
                </div>
                <div class="card-body">
                    <section id="overview" class="mb-5">
                        <h3>Overview</h3>
                        <p>
                            The Form Builder system allows you to create dynamic forms with a variety of field types.
                            Field types are the building blocks of your forms and define how data is collected and validated.
                        </p>
                        <p>
                            Each field type consists of:
                        </p>
                        <ul>
                            <li><strong>Name</strong>: A user-friendly name for the field type</li>
                            <li><strong>Component</strong>: The component used to render the field</li>
                            <li><strong>Category</strong>: For organization and filtering</li>
                            <li><strong>Default Configuration</strong>: JSON configuration for default field behavior</li>
                            <li><strong>Validation Rules</strong>: JSON schema for frontend and backend validation</li>
                            <li><strong>Supported Attributes</strong>: Additional attributes that can be set on the field</li>
                        </ul>
                    </section>
                    
                    <section id="field-types" class="mb-5">
                        <h3>Field Types</h3>
                        <p>
                            The system comes with several built-in field types, including:
                        </p>
                        
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Field Type</th>
                                        <th>Component</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Text</td>
                                        <td><code>text</code></td>
                                        <td>Single line text input</td>
                                    </tr>
                                    <tr>
                                        <td>Textarea</td>
                                        <td><code>textarea</code></td>
                                        <td>Multi-line text input</td>
                                    </tr>
                                    <tr>
                                        <td>Number</td>
                                        <td><code>number</code></td>
                                        <td>Numeric input field</td>
                                    </tr>
                                    <tr>
                                        <td>Email</td>
                                        <td><code>email</code></td>
                                        <td>Email input with validation</td>
                                    </tr>
                                    <tr>
                                        <td>Password</td>
                                        <td><code>password</code></td>
                                        <td>Password input field</td>
                                    </tr>
                                    <tr>
                                        <td>Select</td>
                                        <td><code>select</code></td>
                                        <td>Dropdown selection</td>
                                    </tr>
                                    <tr>
                                        <td>Checkbox</td>
                                        <td><code>checkbox</code></td>
                                        <td>Single checkbox toggle</td>
                                    </tr>
                                    <tr>
                                        <td>Radio</td>
                                        <td><code>radio</code></td>
                                        <td>Radio button group</td>
                                    </tr>
                                    <tr>
                                        <td>Date</td>
                                        <td><code>date</code></td>
                                        <td>Date picker</td>
                                    </tr>
                                    <tr>
                                        <td>File</td>
                                        <td><code>file</code></td>
                                        <td>File upload field</td>
                                    </tr>
                                    <tr>
                                        <td>Hidden</td>
                                        <td><code>hidden</code></td>
                                        <td>Hidden input field</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </section>
                    
                    <section id="creating-fields" class="mb-5">
                        <h3>Creating Field Types</h3>
                        <p>
                            To create a new field type:
                        </p>
                        <ol>
                            <li>Go to <a href="{{ route('field-types.index') }}">Field Types</a></li>
                            <li>Click <strong>Create New Field Type</strong></li>
                            <li>Fill in the required information:
                                <ul>
                                    <li><strong>Name</strong>: A descriptive name for the field type</li>
                                    <li><strong>Category</strong>: Choose an existing category or create a new one</li>
                                    <li><strong>Component Name</strong>: The name of the component used to render this field</li>
                                    <li><strong>Description</strong>: A brief description of what this field type does</li>
                                </ul>
                            </li>
                            <li>Configure the Default Configuration, Validation Rules, and Supported Attributes (see below)</li>
                            <li>Click <strong>Create Field Type</strong></li>
                        </ol>
                    </section>
                    
                    <section id="validation" class="mb-5">
                        <h3>Validation Rules</h3>
                        <p>
                            Validation rules use JSON Schema format to define how field data should be validated. These rules are applied both on the frontend (using the FieldValidator component) and on the backend.
                        </p>
                        
                        <div class="card mb-3">
                            <div class="card-header">
                                Example: Email Validation
                            </div>
                            <div class="card-body">
                                <pre><code>{
  "type": "string",
  "format": "email",
  "minLength": 5,
  "maxLength": 255
}</code></pre>
                            </div>
                        </div>
                        
                        <div class="card mb-3">
                            <div class="card-header">
                                Example: Number Range Validation
                            </div>
                            <div class="card-body">
                                <pre><code>{
  "type": "number",
  "minimum": 1,
  "maximum": 100
}</code></pre>
                            </div>
                        </div>
                        
                        <p>
                            Common validation rules include:
                        </p>
                        <ul>
                            <li><code>type</code>: string, number, boolean, array, object</li>
                            <li><code>required</code>: Whether the field is required</li>
                            <li><code>minLength</code>, <code>maxLength</code>: For strings</li>
                            <li><code>minimum</code>, <code>maximum</code>: For numbers</li>
                            <li><code>pattern</code>: Regular expression for pattern matching</li>
                            <li><code>format</code>: Predefined formats like email, date, etc.</li>
                        </ul>
                    </section>
                    
                    <section id="components" class="mb-5">
                        <h3>Component Reference</h3>
                        <p>
                            Field components are the actual UI elements rendered in the form. Each component has its own set of supported configurations.
                        </p>
                        
                        <div class="accordion" id="componentsAccordion">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="textComponentHeading">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#textComponentCollapse" aria-expanded="false" aria-controls="textComponentCollapse">
                                        Text Component
                                    </button>
                                </h2>
                                <div id="textComponentCollapse" class="accordion-collapse collapse" aria-labelledby="textComponentHeading" data-bs-parent="#componentsAccordion">
                                    <div class="accordion-body">
                                        <h5>Default Configuration</h5>
                                        <pre><code>{
  "placeholder": "Enter text...",
  "required": false,
  "autocomplete": "off",
  "maxlength": 255
}</code></pre>
                                        <h5>Usage Example</h5>
                                        <pre><code>&lt;x-form-field type="text" name="full_name" label="Full Name" 
  placeholder="Enter your full name" required="true" /&gt;</code></pre>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="selectComponentHeading">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#selectComponentCollapse" aria-expanded="false" aria-controls="selectComponentCollapse">
                                        Select Component
                                    </button>
                                </h2>
                                <div id="selectComponentCollapse" class="accordion-collapse collapse" aria-labelledby="selectComponentHeading" data-bs-parent="#componentsAccordion">
                                    <div class="accordion-body">
                                        <h5>Default Configuration</h5>
                                        <pre><code>{
  "placeholder": "Select an option",
  "required": false,
  "multiple": false,
  "options": {
    "option1": "Option 1",
    "option2": "Option 2"
  }
}</code></pre>
                                        <h5>Usage Example</h5>
                                        <pre><code>&lt;x-form-field type="select" name="country" label="Country" 
  :options="$countries" placeholder="Select your country" /&gt;</code></pre>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="checkboxComponentHeading">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#checkboxComponentCollapse" aria-expanded="false" aria-controls="checkboxComponentCollapse">
                                        Checkbox Component
                                    </button>
                                </h2>
                                <div id="checkboxComponentCollapse" class="accordion-collapse collapse" aria-labelledby="checkboxComponentHeading" data-bs-parent="#componentsAccordion">
                                    <div class="accordion-body">
                                        <h5>Default Configuration</h5>
                                        <pre><code>{
  "label": "Check me out",
  "checked": false,
  "value": "1"
}</code></pre>
                                        <h5>Usage Example</h5>
                                        <pre><code>&lt;x-form-field type="checkbox" name="agree_terms" 
  label="I agree to the terms and conditions" required="true" /&gt;</code></pre>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    
                    <section id="json-schema" class="mb-5">
                        <h3>JSON Schema Validation</h3>
                        <p>
                            The form builder uses JSON Schema for field validation. This provides a standardized way to validate form data both on the client-side and server-side.
                        </p>
                        
                        <div class="card mb-3">
                            <div class="card-header">
                                Example: Contact Form Schema
                            </div>
                            <div class="card-body">
                                <pre><code>{
  "type": "object",
  "properties": {
    "name": {
      "type": "string",
      "minLength": 2,
      "maxLength": 100
    },
    "email": {
      "type": "string",
      "format": "email"
    },
    "message": {
      "type": "string",
      "minLength": 10
    }
  },
  "required": ["name", "email", "message"]
}</code></pre>
                            </div>
                        </div>
                        
                        <p>
                            Benefits of using JSON Schema:
                        </p>
                        <ul>
                            <li>Consistent validation across frontend and backend</li>
                            <li>Self-documenting validation rules</li>
                            <li>Support for complex validation scenarios</li>
                            <li>Easily extensible for custom validation</li>
                        </ul>
                    </section>
                    
                    <section id="dependencies" class="mb-5">
                        <h3>Field Dependencies</h3>
                        <p>
                            Field dependencies allow you to show or hide fields based on the values of other fields. This creates dynamic, interactive forms.
                        </p>
                        
                        <div class="card mb-3">
                            <div class="card-header">
                                Example: Show Address Field Only When "Has Physical Address" is Checked
                            </div>
                            <div class="card-body">
                                <pre><code>{
  "targetField": "address",
  "conditions": [
    {
      "field": "has_address",
      "operator": "equals",
      "value": true
    }
  ]
}</code></pre>
                            </div>
                        </div>
                        
                        <p>
                            Available dependency operators:
                        </p>
                        <ul>
                            <li><code>equals</code>: Field value equals the specified value</li>
                            <li><code>not_equals</code>: Field value does not equal the specified value</li>
                            <li><code>contains</code>: Field value contains the specified value</li>
                            <li><code>not_contains</code>: Field value does not contain the specified value</li>
                            <li><code>greater_than</code>: Field value is greater than the specified value</li>
                            <li><code>less_than</code>: Field value is less than the specified value</li>
                            <li><code>empty</code>: Field value is empty</li>
                            <li><code>not_empty</code>: Field value is not empty</li>
                        </ul>
                    </section>
                    
                    <section id="examples" class="mb-5">
                        <h3>Examples</h3>
                        
                        <div class="accordion" id="examplesAccordion">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="contactFormHeading">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#contactFormCollapse" aria-expanded="false" aria-controls="contactFormCollapse">
                                        Contact Form Example
                                    </button>
                                </h2>
                                <div id="contactFormCollapse" class="accordion-collapse collapse" aria-labelledby="contactFormHeading" data-bs-parent="#examplesAccordion">
                                    <div class="accordion-body">
                                        <p>A simple contact form with name, email, subject, and message fields:</p>
                                        <pre><code>&lt;form method="POST" action="{{ route('forms.submit', 'contact') }}"&gt;
    @csrf
    
    &lt;x-form-field type="text" name="name" label="Your Name" required="true" /&gt;
    
    &lt;x-form-field type="email" name="email" label="Email Address" 
                  placeholder="your@email.com" required="true" /&gt;
    
    &lt;x-form-field type="text" name="subject" label="Subject" required="true" /&gt;
    
    &lt;x-form-field type="textarea" name="message" label="Message" 
                  rows="5" required="true" /&gt;
    
    &lt;button type="submit" class="btn btn-primary"&gt;Send Message&lt;/button&gt;
&lt;/form&gt;</code></pre>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="conditionalFieldsHeading">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#conditionalFieldsCollapse" aria-expanded="false" aria-controls="conditionalFieldsCollapse">
                                        Conditional Fields Example
                                    </button>
                                </h2>
                                <div id="conditionalFieldsCollapse" class="accordion-collapse collapse" aria-labelledby="conditionalFieldsHeading" data-bs-parent="#examplesAccordion">
                                    <div class="accordion-body">
                                        <p>A form with conditional fields based on the selected option:</p>
                                        <pre><code>&lt;form method="POST" action="{{ route('forms.submit', 'registration') }}"&gt;
    @csrf
    
    &lt;x-form-field type="text" name="name" label="Your Name" required="true" /&gt;
    
    &lt;x-form-field type="select" name="contact_method" label="Preferred Contact Method" 
                  :options="['email' => 'Email', 'phone' => 'Phone', 'mail' => 'Mail']" 
                  required="true" /&gt;
    
    &lt;x-form-field type="email" name="email" label="Email Address" 
                  data-dependencies='[{"field":"contact_method","operator":"equals","value":"email"}]' /&gt;
    
    &lt;x-form-field type="text" name="phone" label="Phone Number" 
                  data-dependencies='[{"field":"contact_method","operator":"equals","value":"phone"}]' /&gt;
    
    &lt;x-form-field type="textarea" name="mailing_address" label="Mailing Address"
                  data-dependencies='[{"field":"contact_method","operator":"equals","value":"mail"}]' /&gt;
    
    &lt;button type="submit" class="btn btn-primary"&gt;Register&lt;/button&gt;
&lt;/form&gt;</code></pre>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="complexValidationHeading">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#complexValidationCollapse" aria-expanded="false" aria-controls="complexValidationCollapse">
                                        Complex Validation Example
                                    </button>
                                </h2>
                                <div id="complexValidationCollapse" class="accordion-collapse collapse" aria-labelledby="complexValidationHeading" data-bs-parent="#examplesAccordion">
                                    <div class="accordion-body">
                                        <p>A registration form with password validation and date of birth:</p>
                                        <pre><code>&lt;form method="POST" action="{{ route('forms.submit', 'complex-registration') }}"&gt;
    @csrf
    
    &lt;x-form-field type="text" name="username" label="Username" 
                  validation='{"type":"string","pattern":"^[a-zA-Z0-9_]+$","minLength":3,"maxLength":20}' /&gt;
    
    &lt;x-form-field type="password" name="password" label="Password" 
                  validation='{"type":"string","minLength":8,"pattern":"^(?=.*[a-z])(?=.*[A-Z])(?=.*\\d).+$"}' /&gt;
    
    &lt;x-form-field type="password" name="password_confirm" label="Confirm Password" 
                  validation='{"type":"string","const":{"$data":"1/password"}}' /&gt;
    
    &lt;x-form-field type="date" name="birth_date" label="Date of Birth" 
                  validation='{"type":"string","format":"date","formatMaximum":"{{ date("Y-m-d", strtotime("-18 years")) }}"}' /&gt;
    
    &lt;button type="submit" class="btn btn-primary"&gt;Register&lt;/button&gt;
&lt;/form&gt;</code></pre>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    
                    <div class="mt-4">
                        <a href="{{ route('field-types.index') }}" class="btn btn-primary">
                            Back to Field Types
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 