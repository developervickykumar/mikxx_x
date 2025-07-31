 

 
let currentCategoryId = null;


document.addEventListener('click', function(e) {
    if (e.target.closest('.edit-html')) {
        currentCategoryId = e.target.closest('.edit-html').dataset.id;

        $.ajax({
               url: '/admin/html-templates/' + currentCategoryId + '/edit',

            type: 'GET',
            success: function(data) {
                $('#codeEditor').val(data.code);
                updatePreview();
                $('#editHtmlModal').modal('show');
                $('#itemName').val(data.name);
                const labelType = data.label_json?.label || 'Unknown';
                $('#itemType').val(labelType); // Set in select/input field

                // Optional: apply logic based on label type
                if (labelType === 'Page') {
                    // Do something specific for Page
                }

                $('#suggestedPrompt').val(generatePrompt(data.name, labelType));
            },
            error: function(err) {
                console.error('Failed to load HTML:', err);
                alert('Failed to load HTML content.');
            }
        });
    }
});

$('#saveCodeBtn').on('click', function () {
    const htmlCode = $('#codeEditor').val();
    
    const name = $('#itemName').val();
    const labelType = $('#itemType').val();
    const tags = $('#tagsInput').val();
    const improvement_notes = $('#improvementSummary').val();

    const usableInUser = $('#usableUser').is(':checked');
    const usableInBusiness = $('#usableBusiness').is(':checked');
    const usableInMikxx = $('#usableMikxx').is(':checked');
    const usableInModules = $('#usableModules').is(':checked');
    const usableInAdmin = $('#usableAdmin').is(':checked');

    if (!currentCategoryId) {
        appendPageMessage('Category ID not found.', 'danger');
        return;
    }

    $.ajax({
        url: '/admin/html-templates/save-or-update',
        type: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            category_id: currentCategoryId,
            name: name,
            html_code: htmlCode,
            tags: tags,
            improvement_notes: improvement_notes,
            usable_in_user: usableInUser ? 1 : 0,
            usable_in_business: usableInBusiness ? 1 : 0,
            usable_in_mikxx: usableInMikxx ? 1 : 0,
            usable_in_modules: usableInModules ? 1 : 0,
            usable_in_admin: usableInAdmin ? 1 : 0
        },
        success: function (res) {
            $('#editHtmlModal').modal('hide');
            appendPageMessage('HTML Template saved successfully.', 'success');
        },
        error: function (err) {
            console.error(err);
            $('#editHtmlModal').modal('hide');
            appendPageMessage('Failed to save HTML Template.', 'danger');
        }
    });
});






function appendPageMessage(message, type = 'success') {
    const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
    const html = `
        <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    `;
    $('#pageMessage').html(html);
}


$('#backBtn').on('click', function() {
    $('#editHtmlModal').modal('hide');
});
$('#generateAiBtn').on('click', function() {
    console.log('generateAiBtn clicked');
    $('.prompt-section').show(); // Show prompt input
});

$('#generateHtmlBtn').on('click', function() {
    const prompt = $('#suggestedPrompt').val().trim();

    if (!prompt) {
        showToast('Please enter a prompt before generating.', 'warning');
        return;
    }

    $('#codeEditor').val('⏳ Generating HTML from AI...');
    updatePreview();

    $.ajax({
        url: '/admin/ai/generate-html',
        method: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            prompt: prompt
        },
        success: function(res) {
            $('#codeEditor').val(res.generated_html);
            updatePreview();
            showToast('HTML generated successfully');
        },
        error: function() {
            $('#codeEditor').val('');
            updatePreview();
            showToast('AI generation failed. Please try again.', 'error');
        }
    });
});



//

// Sample data
const items = (window.categoriesFromLaravel || []).map(category => ({
    id: category.id,
    name: category.name,
    type: category.type || 'Unknown',
    category: 'uncategorized', // optional: adjust if you have groupings
    status: 'pending' // or get from backend
}));


const registryItems = [
    { name: 'input.blade.php', path: '/components/forms/input.blade.php', type: 'Component', reusable: true, usedIn: ['Login Form', 'Registration Form'], createdOn: '2024-03-15' },
    { name: 'card.blade.php', path: '/components/layout/card.blade.php', type: 'Component', reusable: true, usedIn: ['Dashboard', 'Profile'], createdOn: '2024-03-14' },
    { name: 'button.blade.php', path: '/components/buttons/button.blade.php', type: 'Component', reusable: true, usedIn: ['All Forms'], createdOn: '2024-03-13' }
];

const activityLog = [
    { timestamp: '2024-03-15 14:30', action: 'Prompt sent for Login Form', type: 'prompt' },
    { timestamp: '2024-03-15 14:25', action: 'Component card.blade.php used in Dashboard', type: 'component' },
    { timestamp: '2024-03-15 14:20', action: 'New form created: Registration Form', type: 'create' }
];

const components = [
    { name: 'input.blade.php', type: 'Form Input', description: 'Reusable input component with validation' },
    { name: 'card.blade.php', type: 'Layout', description: 'Card container with header and footer' },
    { name: 'button.blade.php', type: 'Button', description: 'Customizable button component' },
    { name: 'select.blade.php', type: 'Form Input', description: 'Dropdown select component' },
    { name: 'modal.blade.php', type: 'Layout', description: 'Modal dialog component' },
    { name: 'alert.blade.php', type: 'Feedback', description: 'Alert message component' }
];

// Module Status Map
const moduleStatusMap = {};



// Enhanced Checklist Items with Icons
const checklistItems = [
    { id: 'purposeClarity', label: 'Purpose Clarity', icon: '🎯', description: 'Is the functional goal defined?' },
    { id: 'categoryAssigned', label: 'Category Assigned', icon: '📁', description: 'Has it been categorized?' },
    { id: 'duplicateCheck', label: 'Duplicate Check', icon: '🔍', description: 'Does this already exist in Registry?' },
    { id: 'reusableComponents', label: 'Reusable Components', icon: '🧩', description: 'Can existing Blade components be reused?' },
    { id: 'formFieldDetection', label: 'Form Field Detection', icon: '📝', description: 'Are necessary fields defined?' },
    { id: 'actionLinks', label: 'Action Links', icon: '🔗', description: 'Are buttons/routes specified?' },
    { id: 'layoutDecision', label: 'Layout Decision', icon: '📐', description: 'Should it be a tab, modal, full page, or drawer?' },
    { id: 'mobileFriendly', label: 'Mobile-Friendly', icon: '📱', description: 'Is Tailwind responsive layout implemented?' },
    { id: 'dynamicBinding', label: 'Dynamic Binding', icon: '🔄', description: 'Are Blade variables used?' },
    { id: 'validationUI', label: 'Validation UI', icon: '✅', description: 'Is error/success feedback present?' },
    { id: 'promptAvailable', label: 'Prompt Available', icon: '🤖', description: 'Is an AI prompt generated and usable?' },
    { id: 'readyToPublish', label: 'Ready to Publish', icon: '🚀', description: 'Can this be marked "Ready to Publish"?' }
];



if (window.categoriesFromLaravel) {

     window.categoriesFromLaravel.forEach(category => {
        moduleStatusMap[category.id] = {
            checklist: checklistItems.reduce((acc, curr) => ({
                ...acc,
                [curr.id]: {
                    checked: false,
                    feedback: '',
                    lastValidated: null
                }
            }), {}),
            ready: false,
            lastValidated: null
        };
    });
}

 
// DOM Elements
const darkModeToggle = document.getElementById('darkModeToggle');
const modeToggle = document.getElementById('modeToggle');
const sidebar = document.getElementById('sidebar');
const mobileMenuButton = document.getElementById('mobileMenuButton');
const promptDrawer = document.getElementById('promptDrawer');
const closeDrawer = document.getElementById('closeDrawer');
const searchInput = document.getElementById('searchInput');
const categoryFilter = document.getElementById('categoryFilter');
const statusFilter = document.getElementById('statusFilter');
const tabLinks = document.querySelectorAll('.tab-link');
const categoryLinks = document.querySelectorAll('.category-link');
const contentSections = document.querySelectorAll('.content-section');
const componentPickerModal = document.getElementById('componentPickerModal');
const closeComponentPicker = document.getElementById('closeComponentPicker');
const pickComponent = document.getElementById('pickComponent');
const checklistDrawer = document.getElementById('checklistDrawer');
const closeChecklist = document.getElementById('closeChecklist');
const exportChecklist = document.getElementById('exportChecklist');

// Dark Mode Toggle
// darkModeToggle.addEventListener('click', () => {
//     document.documentElement.classList.toggle('dark');
//     const icon = darkModeToggle.querySelector('i');
//     icon.classList.toggle('fa-moon');
//     icon.classList('fa-sun');
// });

// Mobile Menu Toggle
mobileMenuButton.addEventListener('click', () => {
    sidebar.classList.toggle('hidden');
    sidebar.classList.toggle('fixed');
    sidebar.classList.toggle('inset-0');
    sidebar.classList.toggle('z-50');
});

// Tab Switching
tabLinks.forEach(tab => {
    tab.addEventListener('click', (e) => {
        e.preventDefault();
        const tabName = tab.dataset.tab;
        
        // Update tab styles
        tabLinks.forEach(t => {
            t.classList.remove('border-indigo-500', 'text-indigo-600');
            t.classList.add('border-transparent', 'text-gray-500');
        });
        tab.classList.remove('border-transparent', 'text-gray-500');
        tab.classList.add('border-indigo-500', 'text-indigo-600');

        // Show/hide content sections
        contentSections.forEach(section => {
            section.classList.add('hidden');
        });
        document.getElementById(tabName + 'Items')?.classList.remove('hidden');

        // Show/hide filters
        const itemFilters = document.getElementById('itemFilters');
        if (itemFilters) {
            itemFilters.style.display = ['pending', 'built'].includes(tabName) ? 'flex' : 'none';
        }

        // Load content
        switch(tabName) {
            case 'pending':
                renderItems(items.filter(item => item.status !== 'done'));
                break;
            case 'built':
                renderItems(items.filter(item => item.status === 'done'));
                break;
            case 'registry':
                renderRegistry();
                break;
            case 'activity':
                renderActivityLog();
                break;
        }
    });
});

// Generate Prompt
function generatePrompt(name, type) {
    const prompts = {
        'Form': `Create a responsive Tailwind form for ${name.toLowerCase()} with proper validation and error handling. Include submit and cancel buttons.`,
        'Page': `Design a modern ${name.toLowerCase()} page using Tailwind CSS with responsive layout and proper spacing.`,
        'Integration': `Implement ${name.toLowerCase()} integration with proper error handling and loading states.`,
        'Tool': `Create a ${name.toLowerCase()} tool with user-friendly interface and clear instructions.`
    };
    return prompts[type] || `Create a ${type.toLowerCase()} for ${name.toLowerCase()} using Tailwind CSS.`;
}

// Render Items in Table
function renderItems(items) {
    const tableBody = document.getElementById('pendingItemsTableBody') || document.getElementById('builtItemsTableBody');
    if (!tableBody) return;

    tableBody.innerHTML = items.map(item => `
        <tr>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                ${item.name}
                ${moduleStatusMap[item.name]?.ready ? 
                    '<span class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">✅ Ready</span>' : 
                    ''}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">${item.type}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">${item.category}</td>
            <td class="px-6 py-4 whitespace-nowrap">
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                    ${item.status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                      item.status === 'in-progress' ? 'bg-blue-100 text-blue-800' : 
                      'bg-green-100 text-green-800'}">
                    ${item.status.charAt(0).toUpperCase() + item.status.slice(1)}
                </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm space-x-2">
                <button onclick="openPromptDrawer('${item.name}', '${item.type}')" 
                        class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                    Generate Prompt
                </button>
                <button onclick="openChecklist('${item.name}')" 
                        class="bg-gray-100 text-gray-700 px-4 py-2 rounded hover:bg-gray-200">
                    🧾 Checklist
                </button>
                <button onclick="toggleReadyStatus('${item.name}')" 
                        class="px-4 py-2 rounded ${moduleStatusMap[item.name]?.ready ? 
                            'bg-green-600 text-white hover:bg-green-700' : 
                            'bg-gray-100 text-gray-700 hover:bg-gray-200'}">
                    ${moduleStatusMap[item.name]?.ready ? '✅ Ready' : 'Mark Ready'}
                </button>
                <button onclick="openPrebuiltValidator('${item.name}')" 
                        class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700">
                    <i class="fas fa-code mr-2"></i>Validate Prebuilt
                </button>
                <button onclick="openBladeConverter('${item.name}')" 
                        class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                    <i class="fas fa-file-code mr-2"></i>Convert to Blade
                </button>
            </td>
        </tr>
    `).join('');
}

// Render Registry
function renderRegistry() {
    const tableBody = document.getElementById('registryTableBody');
    if (!tableBody) return;

    tableBody.innerHTML = registryItems.map(item => `
        <tr>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 ">${item.name}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">${item.path}</td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">${item.type}</td>
            <td class="px-6 py-4 whitespace-nowrap">
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                    ${item.reusable ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'}">
                    ${item.reusable ? 'Yes' : 'No'}
                </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                ${item.usedIn.join(', ')}
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                ${item.createdOn}
            </td>
        </tr>
    `).join('');
}

// Render Activity Log
function renderActivityLog() {
    const activityList = document.getElementById('activityList');
    if (!activityList) return;

    activityList.innerHTML = activityLog.map(activity => `
        <div class="flex items-start space-x-4">
            <div class="flex-shrink-0">
                <span class="inline-flex items-center justify-center h-8 w-8 rounded-full 
                    ${activity.type === 'prompt' ? 'bg-blue-100 text-blue-800' :
                      activity.type === 'component' ? 'bg-green-100 text-green-800' :
                      'bg-purple-100 text-purple-800'}">
                    <i class="fas ${activity.type === 'prompt' ? 'fa-paper-plane' :
                                 activity.type === 'component' ? 'fa-puzzle-piece' :
                                 'fa-plus'}"></i>
                </span>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm text-gray-900 ">${activity.action}</p>
                <p class="text-sm text-gray-500 dark:text-gray-400">${activity.timestamp}</p>
            </div>
        </div>
    `).join('');
}

// Prompt Drawer Functions
function openPromptDrawer(name, type) {
    document.getElementById('itemName').value = name;
    document.getElementById('itemType').value = type;
    document.getElementById('suggestedPrompt').value = generatePrompt(name, type);
    promptDrawer.classList.remove('translate-x-full');

    // Auto mode behavior
    if (modeToggle.checked) {
        setTimeout(() => {
            document.getElementById('sendToChatGPT').click();
        }, 1000);
    }
}

closeDrawer.addEventListener('click', () => {
    promptDrawer.classList.add('translate-x-full');
});

// Component Picker
pickComponent.addEventListener('click', () => {
    const componentGrid = document.getElementById('componentGrid');
    componentGrid.innerHTML = components.map(component => `
        <div class="p-4 border rounded-lg hover:border-indigo-500 cursor-pointer">
            <h4 class="font-medium text-gray-900 ">${component.name}</h4>
            <p class="text-sm text-gray-500 dark:text-gray-400">${component.type}</p>
            <p class="text-sm text-gray-600 dark:text-gray-300 mt-2">${component.description}</p>
        </div>
    `).join('');
    componentPickerModal.classList.remove('hidden');
});

closeComponentPicker.addEventListener('click', () => {
    componentPickerModal.classList.add('hidden');
});

// Copy Prompt Function
document.getElementById('copyPrompt').addEventListener('click', () => {
    const prompt = document.getElementById('suggestedPrompt').value;
    navigator.clipboard.writeText(prompt).then(() => {
        alert('Prompt copied to clipboard!');
    });
});

// Send to ChatGPT Function
document.getElementById('sendToChatGPT').addEventListener('click', () => {
    const prompt = document.getElementById('suggestedPrompt').value;
    // Here you would implement the actual ChatGPT API integration
    console.log('Sending to ChatGPT:', prompt);
    
    // Add to activity log
    activityLog.unshift({
        timestamp: new Date().toLocaleString(),
        action: `Prompt sent for ${document.getElementById('itemName').value}`,
        type: 'prompt'
    });
    renderActivityLog();
});

// Open Checklist
function openChecklistById(categoryId) {
    const checklistContent = document.getElementById('checklistContent');
    const itemStatus = moduleStatusMap[categoryId];

    if (!itemStatus) {
        alert(`Checklist not initialized for category ID: ${categoryId}`);
        return;
    }

    checklistContent.innerHTML = checklistItems.map(item => {
        const status = itemStatus.checklist?.[item.id] || {};
        return `
            <div class="flex items-start space-x-3 mb-4">
                <div class="flex-shrink-0 pt-1">
                    <input type="checkbox" 
                           id="${item.id}-${categoryId}" 
                           class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                           ${status.checked ? 'checked' : ''}
                           onchange="updateChecklistById(${categoryId}, '${item.id}', this.checked)">
                </div>
                <div class="flex-1">
                    <label for="${item.id}-${categoryId}" class="text-sm font-medium text-gray-900  flex items-center">
                        <span class="mr-2">${item.icon}</span>
                        ${item.label}
                    </label>
                    <p class="text-sm text-gray-500 dark:text-gray-400">${item.description}</p>
                    ${status.feedback ? `
                        <p class="mt-1 text-sm text-indigo-600 dark:text-indigo-400">
                            ${status.feedback}
                        </p>` : ''}
                </div>
            </div>
        `;
    }).join('');

    updateProgressById(categoryId);
    checklistDrawer.classList.remove('translate-x-full');
}

// Update Checklist
function updateChecklistById(categoryId, itemId, checked) {
    const status = moduleStatusMap[categoryId];
    if (!status || !status.checklist[itemId]) return;

    status.checklist[itemId].checked = checked;
    status.checklist[itemId].lastValidated = new Date();

    updateProgressById(categoryId);

    // Check if all items are checked
    const allChecked = Object.values(status.checklist).every(item => item.checked);

    // Update ready status
    if (allChecked && !status.ready) {
        status.ready = true;
        renderItems(items); // Optional: re-render item table if applicable
    }
}


// Toggle Ready Status
function toggleReadyStatus(itemName) {
    const itemStatus = moduleStatusMap[itemName];
    const allChecked = Object.values(itemStatus.checklist).every(Boolean);
    
    if (allChecked) {
        itemStatus.ready = !itemStatus.ready;
        renderItems(items);
    } else {
        alert('Please complete all checklist items first!');
    }
}

// Export Checklist
exportChecklist.addEventListener('click', () => {
    const csvContent = Object.entries(moduleStatusMap)
        .map(([name, status]) => {
            const checklist = Object.entries(status.checklist)
                .map(([key, value]) => `${key}:${value}`)
                .join(',');
            return `${name},${status.ready},${checklist}`;
        })
        .join('\n');

    const blob = new Blob([csvContent], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'module-checklist.csv';
    a.click();
});

// Category Links
categoryLinks.forEach(link => {
    link.addEventListener('click', (e) => {
        e.preventDefault();
        const category = link.dataset.category;
        filterItemsByCategory(category);
    });
});

// Close Checklist
closeChecklist.addEventListener('click', () => {
    checklistDrawer.classList.add('translate-x-full');
});

// Event Listeners for Filters
searchInput.addEventListener('input', filterItems);
categoryFilter.addEventListener('change', filterItems);
statusFilter.addEventListener('change', filterItems);

// Update Progress Bar
function updateProgressById(categoryId) {
    const itemStatus = moduleStatusMap[categoryId];
    const total = checklistItems.length;
    const checked = Object.values(itemStatus.checklist).filter(i => i.checked).length;
    const progress = (checked / total) * 100;

    document.getElementById('progressBar').style.width = `${progress}%`;
    document.getElementById('checklistProgress').textContent = `${Math.round(progress)}%`;
}

// Validate with AI
document.getElementById('validateWithAI').addEventListener('click', async () => {
    const currentItem = document.querySelector('#checklistContent').dataset.itemName;
    const aiFeedback = document.getElementById('aiFeedback');
    const aiFeedbackText = document.getElementById('aiFeedbackText');
    
    try {
        // Show loading state
        aiFeedback.classList.remove('hidden');
        aiFeedbackText.textContent = 'Validating with AI...';
        
        // Here you would make the actual ChatGPT API call
        // For now, we'll simulate a response
        const response = await simulateAIValidation(currentItem);
        
        // Update feedback
        aiFeedbackText.textContent = response.feedback;
        
        // Update checklist items based on AI feedback
        response.validations.forEach(validation => {
            if (moduleStatusMap[currentItem].checklist[validation.id]) {
                moduleStatusMap[currentItem].checklist[validation.id] = {
                    checked: validation.checked,
                    feedback: validation.feedback,
                    lastValidated: new Date()
                };
            }
        });
        
        // Refresh checklist view
        openChecklist(currentItem);
        
    } catch (error) {
        aiFeedbackText.textContent = 'Error validating with AI. Please try again.';
    }
});

// Simulate AI Validation (Replace with actual ChatGPT API call)
async function simulateAIValidation(itemName) {
    // Simulate API delay
    await new Promise(resolve => setTimeout(resolve, 1000));
    
    return {
        feedback: "AI validation complete. All required checks passed. Ready for publication.",
        validations: checklistItems.map(item => ({
            id: item.id,
            checked: true,
            feedback: `Validated by AI: ${item.label}`
        }))
    };
}

// Improvement Tracking System
const improvements = {
    ui: [
        { id: 'ui1', label: 'Add keyboard shortcuts for common actions', status: 'pending' },
        { id: 'ui2', label: 'Implement drag-and-drop for checklist items', status: 'pending' },
        { id: 'ui3', label: 'Add tooltips for better user guidance', status: 'pending' }
    ],
    ai: [
        { id: 'ai1', label: 'Implement real-time AI suggestions', status: 'pending' },
        { id: 'ai2', label: 'Add AI-powered code review', status: 'pending' },
        { id: 'ai3', label: 'Implement automated test generation', status: 'pending' }
    ],
    performance: [
        { id: 'perf1', label: 'Implement lazy loading for large lists', status: 'pending' },
        { id: 'perf2', label: 'Add caching for AI responses', status: 'pending' },
        { id: 'perf3', label: 'Optimize checklist rendering', status: 'pending' }
    ],
    features: [
        { id: 'feat1', label: 'Add version control integration', status: 'pending' },
        { id: 'feat2', label: 'Implement team collaboration features', status: 'pending' },
        { id: 'feat3', label: 'Add custom checklist templates', status: 'pending' }
    ]
};

// Add Improvement Tracking Button to Header
const headerActions = document.querySelector('.flex.items-center.space-x-4');
const improvementButton = document.createElement('button');
improvementButton.className = 'bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700';
improvementButton.innerHTML = '<i class="fas fa-list-check mr-2"></i>Improvements';
improvementButton.onclick = () => document.getElementById('improvementModal').classList.remove('hidden');
headerActions.insertBefore(improvementButton, headerActions.firstChild);

// Close Improvement Modal
document.getElementById('closeImprovementModal').addEventListener('click', () => {
    document.getElementById('improvementModal').classList.add('hidden');
});

// Save Improvements
document.getElementById('saveImprovements').addEventListener('click', () => {
    const checkboxes = document.querySelectorAll('#improvementModal input[type="checkbox"]');
    checkboxes.forEach(checkbox => {
        const category = checkbox.id.substring(0, 3);
        const index = parseInt(checkbox.id.substring(3)) - 1;
        improvements[category][index].status = checkbox.checked ? 'completed' : 'pending';
    });
    alert('Improvements saved successfully!');
});

// Export Improvements
document.getElementById('exportImprovements').addEventListener('click', () => {
    const csvContent = Object.entries(improvements)
        .map(([category, items]) => 
            items.map(item => `${category},${item.id},${item.label},${item.status}`).join('\n')
        )
        .join('\n');

    const blob = new Blob([csvContent], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'improvements-list.csv';
    a.click();
});

// Validation Checklist
const validationChecklist = [
    {
        id: 'purposeDefined',
        label: 'Purpose Defined',
        description: 'Is the functional intent of this module clearly stated?',
        icon: '🎯'
    },
    {
        id: 'categoryMapped',
        label: 'Category Mapped',
        description: 'Is the module assigned to a valid type?',
        icon: '📁'
    },
    {
        id: 'duplicateExists',
        label: 'Duplicate Exists?',
        description: 'Does a similar module already exist in the system?',
        icon: '🔍'
    },
    {
        id: 'bladeComponentReuse',
        label: 'Blade Component Reuse',
        description: 'Are reusable UI components already available?',
        icon: '🧩'
    },
    {
        id: 'fieldsAndElements',
        label: 'Fields & Elements',
        description: 'Are all required input fields or visual elements defined?',
        icon: '📝'
    },
    {
        id: 'layoutFormat',
        label: 'Layout Format Decided',
        description: 'Should this module appear as a page, tab, modal, or drawer?',
        icon: '📐'
    },
    {
        id: 'buttonAndActionLogic',
        label: 'Button & Action Logic',
        description: 'Are all necessary buttons present and described?',
        icon: '🔘'
    },
    {
        id: 'dynamicVariables',
        label: 'Dynamic Variables Mapped',
        description: 'Are dynamic data points identified?',
        icon: '🔄'
    },
    {
        id: 'validationFeedback',
        label: 'Validation Feedback Planned',
        description: 'Is form or input validation logic considered?',
        icon: '✅'
    },
    {
        id: 'mobileResponsive',
        label: 'Mobile Responsive Plan',
        description: 'Is Tailwind CSS used with responsive structure?',
        icon: '📱'
    },
    {
        id: 'aiPrompt',
        label: 'AI Prompt Generated',
        description: 'Has a usable ChatGPT prompt been auto-generated?',
        icon: '🤖'
    },
    {
        id: 'readyToPublish',
        label: 'Ready to Publish Flag',
        description: 'Can this module be marked as ready?',
        icon: '🚀'
    }
];

// Add Validator Button to Header
const validatorButton = document.createElement('button');
validatorButton.className = 'bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700';
validatorButton.innerHTML = '<i class="fas fa-check-circle mr-2"></i>Validate Module';
validatorButton.onclick = () => document.getElementById('validatorModal').classList.remove('hidden');
headerActions.insertBefore(validatorButton, headerActions.firstChild);

// Close Validator Modal
document.getElementById('closeValidatorModal').addEventListener('click', () => {
    document.getElementById('validatorModal').classList.add('hidden');
});

// Run Validation
document.getElementById('runValidation').addEventListener('click', async () => {
    const moduleName = document.getElementById('moduleName').value;
    const moduleCategory = document.getElementById('moduleCategory').value;
    
    if (!moduleName) {
        alert('Please enter a module name');
        return;
    }

    // Show loading state
    const validationResults = document.getElementById('validationResults');
    validationResults.innerHTML = '<div class="text-center py-4"><i class="fas fa-spinner fa-spin text-2xl text-indigo-600"></i></div>';

    try {
        // Simulate AI validation (replace with actual ChatGPT API call)
        const results = await simulateValidation(moduleName, moduleCategory);
        
        // Display results
        displayValidationResults(results);
        
        // Show final verdict
        showFinalVerdict(results);
        
    } catch (error) {
        validationResults.innerHTML = '<div class="text-red-600">Error running validation. Please try again.</div>';
    }
});

// Simulate Validation (Replace with actual ChatGPT API call)
async function simulateValidation(moduleName, category) {
    await new Promise(resolve => setTimeout(resolve, 1500));
    
    return validationChecklist.map(item => ({
        ...item,
        status: Math.random() > 0.3 ? '✅' : (Math.random() > 0.5 ? '❌' : '⚠️'),
        feedback: `Sample feedback for ${item.label}`
    }));
}

// Display Validation Results
function displayValidationResults(results) {
    const validationResults = document.getElementById('validationResults');
    validationResults.innerHTML = results.map(item => `
        <div class="flex items-start space-x-4 p-4 bg-white dark:bg-gray-800 rounded-lg shadow-sm">
            <div class="flex-shrink-0 text-2xl">${item.icon}</div>
            <div class="flex-1">
                <div class="flex items-center justify-between">
                    <h4 class="text-sm font-medium text-gray-900 ">${item.label}</h4>
                    <span class="text-lg">${item.status}</span>
                </div>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">${item.description}</p>
                ${item.feedback ? `
                    <p class="mt-2 text-sm ${item.status === '✅' ? 'text-green-600' : 
                                          item.status === '❌' ? 'text-red-600' : 
                                          'text-yellow-600'}">
                        ${item.feedback}
                    </p>
                ` : ''}
            </div>
        </div>
    `).join('');
}

// Show Final Verdict
function showFinalVerdict(results) {
    const finalVerdict = document.getElementById('finalVerdict');
    const verdictIcon = document.getElementById('verdictIcon');
    const verdictText = document.getElementById('verdictText');
    const suggestedFixes = document.getElementById('suggestedFixes');

    const failedChecks = results.filter(item => item.status !== '✅');
    const needsAttention = results.filter(item => item.status === '⚠️');

    let verdict = 'Approved';
    let icon = '✅';
    let color = 'text-green-600';

    if (failedChecks.length > 0) {
        verdict = 'Do Not Proceed';
        icon = '❌';
        color = 'text-red-600';
    } else if (needsAttention.length > 0) {
        verdict = 'Needs Fixes';
        icon = '⚠️';
        color = 'text-yellow-600';
    }

    verdictIcon.textContent = icon;
    verdictText.textContent = verdict;
    verdictText.className = `text-lg font-semibold ${color}`;

    // Show suggested fixes
    suggestedFixes.innerHTML = failedChecks.map(item => `
        <div class="flex items-center space-x-2">
            <span class="text-red-600">•</span>
            <span class="text-sm text-gray-700 dark:text-gray-300">${item.feedback}</span>
        </div>
    `).join('');

    finalVerdict.classList.remove('hidden');
}

// Export Validation Report
document.getElementById('exportValidation').addEventListener('click', () => {
    const moduleName = document.getElementById('moduleName').value;
    const moduleCategory = document.getElementById('moduleCategory').value;
    const results = Array.from(document.querySelectorAll('#validationResults > div'))
        .map(div => {
            const label = div.querySelector('h4').textContent;
            const status = div.querySelector('span:last-child').textContent;
            const feedback = div.querySelector('p:last-child')?.textContent || '';
            return `${label},${status},${feedback}`;
        })
        .join('\n');

    const csvContent = `Module Name,${moduleName}\nCategory,${moduleCategory}\n\n${results}`;
    const blob = new Blob([csvContent], { type: 'text/csv' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `validation-report-${moduleName}.csv`;
    a.click();
});

// Initial render
renderItems(items.filter(item => item.status !== 'done'));

// Enhanced AI Analysis System
const aiAnalysisSystem = {
    // Analysis Categories
    categories: {
        structure: {
            icon: '🏗️',
            label: 'Structure Analysis',
            description: 'Module architecture and component organization'
        },
        accessibility: {
            icon: '♿',
            label: 'Accessibility',
            description: 'WCAG compliance and user accessibility'
        },
        performance: {
            icon: '⚡',
            label: 'Performance',
            description: 'Loading speed and resource optimization'
        },
        security: {
            icon: '🔒',
            label: 'Security',
            description: 'Data handling and security measures'
        },
        maintainability: {
            icon: '🔧',
            label: 'Maintainability',
            description: 'Code quality and future maintenance'
        }
    },

    // Generate Detailed Analysis
    async generateAnalysis(moduleName, category) {
        // Simulate AI analysis (replace with actual ChatGPT API call)
        await new Promise(resolve => setTimeout(resolve, 1500));

        return {
            structure: {
                status: '⚠️',
                feedback: 'Consider implementing a more modular structure',
                suggestions: [
                    'Split large components into smaller, reusable ones',
                    'Implement proper component hierarchy',
                    'Use consistent naming conventions'
                ],
                codeExample: `
// Example of improved component structure
<template>
<div class="module-container">
<header-component />
<main-content>
    <form-component />
    <validation-component />
</main-content>
<footer-component />
</div>
</template>`
            },
            accessibility: {
                status: '✅',
                feedback: 'Good accessibility implementation',
                suggestions: [
                    'Add ARIA labels to interactive elements',
                    'Ensure proper color contrast',
                    'Implement keyboard navigation'
                ],
                codeExample: `
// Example of accessibility improvements
<button 
aria-label="Submit form"
class="btn-primary"
role="button"
tabindex="0">
Submit
</button>`
            },
            performance: {
                status: '❌',
                feedback: 'Performance optimizations needed',
                suggestions: [
                    'Implement lazy loading for images',
                    'Optimize CSS selectors',
                    'Use proper caching strategies'
                ],
                codeExample: `
// Example of performance optimization
const lazyLoadImage = (image) => {
const observer = new IntersectionObserver((entries) => {
entries.forEach(entry => {
    if (entry.isIntersecting) {
        entry.target.src = entry.target.dataset.src;
        observer.unobserve(entry.target);
    }
});
});
observer.observe(image);
};`
            },
            security: {
                status: '⚠️',
                feedback: 'Security measures need attention',
                suggestions: [
                    'Implement CSRF protection',
                    'Add input sanitization',
                    'Use secure data transmission'
                ],
                codeExample: `
// Example of security implementation
const sanitizeInput = (input) => {
return input.replace(/[<>]/g, '');
};

const validateData = (data) => {
return Object.entries(data).every(([key, value]) => {
return typeof value === 'string' && value.length < 1000;
});
};`
            },
            maintainability: {
                status: '✅',
                feedback: 'Good code maintainability',
                suggestions: [
                    'Add comprehensive documentation',
                    'Implement unit tests',
                    'Use consistent code style'
                ],
                codeExample: `
/**
* @component FormValidator
* @description Validates form inputs and provides feedback
* @param {Object} config - Validation configuration
* @returns {Object} Validation methods
*/
class FormValidator {
constructor(config) {
this.config = config;
}

validate() {
// Implementation
}
}`
            }
        };
    },

    // Display Analysis Results
    displayAnalysis(analysis) {
        const analysisContent = document.getElementById('analysisContent');
        const suggestionsContent = document.getElementById('suggestionsContent');
        const codeContent = document.getElementById('codeContent');

        // Analysis Tab Content
        analysisContent.innerHTML = Object.entries(analysis).map(([category, data]) => `
            <div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                <div class="flex items-center justify-between mb-2">
                    <div class="flex items-center">
                        <span class="text-2xl mr-2">${this.categories[category].icon}</span>
                        <h3 class="text-sm font-medium text-gray-900 ">
                            ${this.categories[category].label}
                        </h3>
                    </div>
                    <span class="text-lg">${data.status}</span>
                </div>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">
                    ${this.categories[category].description}
                </p>
                <p class="text-sm ${data.status === '✅' ? 'text-green-600' : 
                                  data.status === '❌' ? 'text-red-600' : 
                                  'text-yellow-600'}">
                    ${data.feedback}
                </p>
            </div>
        `).join('');

        // Suggestions Tab Content
        suggestionsContent.innerHTML = Object.entries(analysis).map(([category, data]) => `
            <div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                <div class="flex items-center mb-2">
                    <span class="text-2xl mr-2">${this.categories[category].icon}</span>
                    <h3 class="text-sm font-medium text-gray-900 ">
                        ${this.categories[category].label}
                    </h3>
                </div>
                <ul class="list-disc list-inside space-y-1">
                    ${data.suggestions.map(suggestion => `
                        <li class="text-sm text-gray-700 dark:text-gray-300">${suggestion}</li>
                    `).join('')}
                </ul>
            </div>
        `).join('');

        // Code Examples Tab Content
        codeContent.innerHTML = Object.entries(analysis).map(([category, data]) => `
            <div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                <div class="flex items-center mb-2">
                    <span class="text-2xl mr-2">${this.categories[category].icon}</span>
                    <h3 class="text-sm font-medium text-gray-900 ">
                        ${this.categories[category].label}
                    </h3>
                </div>
                <pre class="bg-gray-50 dark:bg-gray-900 p-3 rounded-lg overflow-x-auto">
                    <code class="text-sm text-gray-800 dark:text-gray-200">${data.codeExample}</code>
                </pre>
            </div>
        `).join('');
    }
};

// Enhanced Validation with AI Analysis
document.getElementById('runValidation').addEventListener('click', async () => {
    const moduleName = document.getElementById('moduleName').value;
    const moduleCategory = document.getElementById('moduleCategory').value;
    
    if (!moduleName) {
        alert('Please enter a module name');
        return;
    }

    // Show loading state
    const validationResults = document.getElementById('validationResults');
    validationResults.innerHTML = '<div class="text-center py-4"><i class="fas fa-spinner fa-spin text-2xl text-indigo-600"></i></div>';

    try {
        // Run validation
        const results = await simulateValidation(moduleName, moduleCategory);
        displayValidationResults(results);
        showFinalVerdict(results);

        // Generate and display AI analysis
        const analysis = await aiAnalysisSystem.generateAnalysis(moduleName, moduleCategory);
        aiAnalysisSystem.displayAnalysis(analysis);

        // Show AI feedback panel
        document.getElementById('aiFeedbackPanel').classList.remove('translate-x-full');

    } catch (error) {
        validationResults.innerHTML = '<div class="text-red-600">Error running validation. Please try again.</div>';
    }
});

// AI Feedback Panel Tabs
document.querySelectorAll('.ai-tab').forEach(tab => {
    tab.addEventListener('click', () => {
        // Update tab styles
        document.querySelectorAll('.ai-tab').forEach(t => {
            t.classList.remove('text-indigo-600', 'border-indigo-600');
            t.classList.add('text-gray-500', 'border-transparent');
        });
        tab.classList.remove('text-gray-500', 'border-transparent');
        tab.classList.add('text-indigo-600', 'border-indigo-600');

        // Show selected content
        const tabName = tab.dataset.tab;
        document.querySelectorAll('#analysisContent, #suggestionsContent, #codeContent')
            .forEach(content => content.classList.add('hidden'));
        document.getElementById(tabName + 'Content').classList.remove('hidden');
    });
});

// Close AI Feedback Panel
document.getElementById('closeAIFeedback').addEventListener('click', () => {
    document.getElementById('aiFeedbackPanel').classList.add('translate-x-full');
});

// Regenerate Analysis
document.getElementById('regenerateAnalysis').addEventListener('click', async () => {
    const moduleName = document.getElementById('moduleName').value;
    const moduleCategory = document.getElementById('moduleCategory').value;
    
    try {
        const analysis = await aiAnalysisSystem.generateAnalysis(moduleName, moduleCategory);
        aiAnalysisSystem.displayAnalysis(analysis);
    } catch (error) {
        alert('Error regenerating analysis. Please try again.');
    }
});

// Export Analysis
document.getElementById('exportAnalysis').addEventListener('click', () => {
    const moduleName = document.getElementById('moduleName').value;
    const moduleCategory = document.getElementById('moduleCategory').value;
    
    const analysis = {
        moduleName,
        moduleCategory,
        timestamp: new Date().toISOString(),
        categories: Object.entries(aiAnalysisSystem.categories).map(([key, value]) => ({
            category: value.label,
            status: document.querySelector(`#analysisContent [data-category="${key}"] .status`).textContent,
            feedback: document.querySelector(`#analysisContent [data-category="${key}"] .feedback`).textContent,
            suggestions: Array.from(document.querySelectorAll(`#suggestionsContent [data-category="${key}"] li`))
                .map(li => li.textContent)
        }))
    };

    const jsonContent = JSON.stringify(analysis, null, 2);
    const blob = new Blob([jsonContent], { type: 'application/json' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `ai-analysis-${moduleName}.json`;
    a.click();
});

// Prebuilt Code Validator System
const prebuiltValidator = {
    // Enhanced Validation Checklist
    checklist: [
        { id: 'purposeDefined', label: 'Purpose Clearly Defined', icon: '🎯', description: 'Is the functional goal clearly stated?' },
        { id: 'categoryAssigned', label: 'Correct Category Assigned', icon: '📁', description: 'Is the module properly categorized?' },
        { id: 'duplicateCheck', label: 'Duplicate Not Found in Registry', icon: '🔍', description: 'Is this a unique module?' },
        { id: 'bladeComponents', label: 'Blade Components Reused', icon: '🧩', description: 'Are reusable components utilized?' },
        { id: 'fieldsComplete', label: 'Fields & Elements Complete', icon: '📝', description: 'Are all necessary fields present?' },
        { id: 'layoutFormat', label: 'Layout Format Appropriate', icon: '📐', description: 'Is the layout type suitable?' },
        { id: 'actionButtons', label: 'Action Buttons Present & Labeled', icon: '🔘', description: 'Are all actions properly defined?' },
        { id: 'bladeVariables', label: 'Dynamic Blade Variables Used', icon: '🔄', description: 'Are variables properly implemented?' },
        { id: 'validationHandling', label: 'Validation Handling Exists', icon: '✅', description: 'Is error/success feedback present?' },
        { id: 'responsiveDesign', label: 'Tailwind CSS Responsiveness', icon: '📱', description: 'Is mobile responsiveness implemented?' },
        { id: 'internalLinks', label: 'Internal Links/Routes Connected', icon: '🔗', description: 'Are all links properly routed?' },
        { id: 'promptGenerated', label: 'ChatGPT Prompt Generated', icon: '🤖', description: 'Is an AI prompt available?' },
        { id: 'readyToPublish', label: 'Ready to Publish Status', icon: '🚀', description: 'Is the module ready for deployment?' },
        { id: 'finalReview', label: 'Final Review Completed', icon: '📋', description: 'Has the module been reviewed?' }
    ],

    // Extract Enhanced Metadata
    extractMetadata(code) {
        const metadata = {
            fileName: '',
            moduleName: '',
            category: '',
            layoutType: '',
            inputFields: [],
            buttons: [],
            bladeComponents: [],
            tailwindClasses: [],
            bladeVariables: [],
            validationPresence: false,
            aiPrompt: false,
            linkedRoutes: [],
            responsiveClasses: [],
            errorHandling: false,
            successHandling: false
        };

        // Extract file name and module name
        const fileNameMatch = code.match(/<title>(.*?)<\/title>/i);
        metadata.moduleName = fileNameMatch ? fileNameMatch[1] : '';
        metadata.fileName = metadata.moduleName.toLowerCase().replace(/\s+/g, '-') + '.blade.php';

        // Extract layout type with more precision
        if (code.includes('modal')) metadata.layoutType = 'Modal';
        else if (code.includes('drawer')) metadata.layoutType = 'Drawer';
        else if (code.includes('tab')) metadata.layoutType = 'Tab';
        else metadata.layoutType = 'Page';

        // Enhanced input field detection
        const inputMatches = code.match(/<input[^>]+>/g) || [];
        metadata.inputFields = inputMatches.map(input => {
            const typeMatch = input.match(/type="([^"]+)"/);
            const nameMatch = input.match(/name="([^"]+)"/);
            const requiredMatch = input.match(/required/);
            return {
                type: typeMatch ? typeMatch[1] : 'text',
                name: nameMatch ? nameMatch[1] : '',
                required: !!requiredMatch
            };
        });

        // Enhanced button detection
        const buttonMatches = code.match(/<button[^>]*>([^<]+)<\/button>/g) || [];
        metadata.buttons = buttonMatches.map(button => {
            const textMatch = button.match(/>([^<]+)</);
            const typeMatch = button.match(/type="([^"]+)"/);
            return {
                text: textMatch ? textMatch[1].trim() : '',
                type: typeMatch ? typeMatch[1] : 'button'
            };
        });

        // Enhanced Blade component detection
        const componentMatches = code.match(/@include\(['"]([^'"]+)['"]\)/g) || [];
        metadata.bladeComponents = componentMatches.map(comp => {
            const nameMatch = comp.match(/['"]([^'"]+)['"]/);
            return nameMatch ? nameMatch[1] : '';
        });

        // Enhanced Tailwind class detection
        const classMatches = code.match(/class="([^"]+)"/g) || [];
        metadata.tailwindClasses = classMatches.map(cls => {
            const classes = cls.match(/class="([^"]+)"/)[1].split(' ');
            return classes.filter(c => c.startsWith('w-') || c.startsWith('flex') || c.startsWith('grid'));
        }).flat();

        // Enhanced responsive class detection
        metadata.responsiveClasses = metadata.tailwindClasses.filter(c => 
            c.includes('sm:') || c.includes('md:') || c.includes('lg:') || c.includes('xl:')
        );

        // Enhanced Blade variable detection
        const variableMatches = code.match(/{{[^}]+}}/g) || [];
        metadata.bladeVariables = variableMatches.map(v => v.trim());

        // Enhanced validation detection
        metadata.validationPresence = code.includes('@error') || 
                                   code.includes('alert') || 
                                   code.includes('validation');
        metadata.errorHandling = code.includes('@error') || code.includes('alert-danger');
        metadata.successHandling = code.includes('alert-success');

        // Enhanced AI prompt detection
        metadata.aiPrompt = code.includes('<!-- AI Prompt:') || 
                          code.includes('<!-- ChatGPT:') ||
                          code.includes('<!-- Module Prompt:');

        // Enhanced route detection
        const routeMatches = code.match(/href="([^"]+)"/g) || [];
        metadata.linkedRoutes = routeMatches.map(route => {
            const hrefMatch = route.match(/href="([^"]+)"/);
            return hrefMatch ? hrefMatch[1] : '';
        });

        return metadata;
    },

    // Enhanced Validation Logic
    validateChecklistItem(itemId, metadata) {
        const validations = {
            purposeDefined: () => ({
                status: metadata.moduleName ? '✅' : '❌',
                feedback: metadata.moduleName ? 
                    `Purpose defined as: ${metadata.moduleName}` : 
                    'No clear purpose defined'
            }),
            categoryAssigned: () => ({
                status: metadata.category ? '✅' : '❌',
                feedback: metadata.category ? 
                    `Category: ${metadata.category}` : 
                    'No category assigned'
            }),
            duplicateCheck: () => ({
                status: '⚠️',
                feedback: 'Similar files may exist in registry'
            }),
            bladeComponents: () => ({
                status: metadata.bladeComponents.length > 0 ? '✅' : '⚠️',
                feedback: metadata.bladeComponents.length > 0 ?
                    `Using components: ${metadata.bladeComponents.join(', ')}` :
                    'No reusable components detected'
            }),
            fieldsComplete: () => ({
                status: metadata.inputFields.length > 0 ? '✅' : '❌',
                feedback: metadata.inputFields.length > 0 ?
                    `Found fields: ${metadata.inputFields.map(f => f.name).join(', ')}` :
                    'No input fields detected'
            }),
            layoutFormat: () => ({
                status: '✅',
                feedback: `Layout type: ${metadata.layoutType}`
            }),
            actionButtons: () => ({
                status: metadata.buttons.length > 0 ? '✅' : '❌',
                feedback: metadata.buttons.length > 0 ?
                    `Found buttons: ${metadata.buttons.map(b => b.text).join(', ')}` :
                    'No buttons detected'
            }),
            bladeVariables: () => ({
                status: metadata.bladeVariables.length > 0 ? '✅' : '⚠️',
                feedback: metadata.bladeVariables.length > 0 ?
                    `Using variables: ${metadata.bladeVariables.join(', ')}` :
                    'No Blade variables detected'
            }),
            validationHandling: () => ({
                status: metadata.validationPresence ? '✅' : '❌',
                feedback: metadata.validationPresence ?
                    (metadata.errorHandling && metadata.successHandling ? 
                        'Complete validation handling present' :
                        'Partial validation handling detected') :
                    'No validation handling detected'
            }),
            responsiveDesign: () => ({
                status: metadata.responsiveClasses.length > 0 ? '✅' : '❌',
                feedback: metadata.responsiveClasses.length > 0 ?
                    `Responsive classes detected: ${metadata.responsiveClasses.join(', ')}` :
                    'No responsive design detected'
            }),
            internalLinks: () => ({
                status: metadata.linkedRoutes.length > 0 ? '✅' : '⚠️',
                feedback: metadata.linkedRoutes.length > 0 ?
                    `Routes detected: ${metadata.linkedRoutes.join(', ')}` :
                    'No routes detected'
            }),
            promptGenerated: () => ({
                status: metadata.aiPrompt ? '✅' : '❌',
                feedback: metadata.aiPrompt ?
                    'AI prompt found in code' :
                    'No AI prompt detected'
            }),
            readyToPublish: () => ({
                status: '⚠️',
                feedback: 'Review required before publishing'
            }),
            finalReview: () => ({
                status: '⚠️',
                feedback: 'Final review pending'
            })
        };

        return validations[itemId]();
    },

    // Enhanced Results Display
    displayResults(validationResults) {
        const resultsContainer = document.getElementById('prebuiltValidationResults');
        const { metadata, results } = validationResults;

        // Display metadata section
        let html = `
            <div class="p-4 bg-gray-50 dark:bg-gray-700 rounded-lg mb-4">
                <h3 class="text-sm font-medium text-gray-900  mb-2">Module Details</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-300">
                            <span class="font-medium">File:</span> ${metadata.fileName}
                        </p>
                        <p class="text-sm text-gray-600 dark:text-gray-300">
                            <span class="font-medium">Module:</span> ${metadata.moduleName}
                        </p>
                        <p class="text-sm text-gray-600 dark:text-gray-300">
                            <span class="font-medium">Layout:</span> ${metadata.layoutType}
                        </p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600 dark:text-gray-300">
                            <span class="font-medium">Fields:</span> ${metadata.inputFields.length}
                        </p>
                        <p class="text-sm text-gray-600 dark:text-gray-300">
                            <span class="font-medium">Components:</span> ${metadata.bladeComponents.length}
                        </p>
                        <p class="text-sm text-gray-600 dark:text-gray-300">
                            <span class="font-medium">Routes:</span> ${metadata.linkedRoutes.length}
                        </p>
                    </div>
                </div>
            </div>
        `;

        // Display checklist results
        html += `
            <div class="space-y-2">
                ${this.checklist.map(item => {
                    const result = results[item.id];
                    return `
                        <div class="p-3 bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <span class="text-xl mr-2">${item.icon}</span>
                                    <div>
                                        <span class="text-sm font-medium text-gray-900 ">
                                            ${item.label}
                                        </span>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            ${item.description}
                                        </p>
                                    </div>
                                </div>
                                <span class="text-lg">${result.status}</span>
                            </div>
                            <p class="mt-1 text-sm ${result.status === '✅' ? 'text-green-600' : 
                                                  result.status === '❌' ? 'text-red-600' : 
                                                  'text-yellow-600'}">
                                ${result.feedback}
                            </p>
                        </div>
                    `;
                }).join('')}
            </div>
        `;

        // Display final verdict with suggested fixes
        const failedChecks = Object.entries(results)
            .filter(([key, value]) => value.status === '❌')
            .map(([key, value]) => ({
                item: this.checklist.find(c => c.id === key),
                feedback: value.feedback
            }));

        html += `
            <div class="mt-4 p-4 bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                <h3 class="text-sm font-medium text-gray-900  mb-2">Final Verdict</h3>
                <div class="flex items-center justify-between">
                    <span class="text-lg font-semibold ${results.finalVerdict.status === 'Approved' ? 'text-green-600' : 
                                                       results.finalVerdict.status === 'Needs Fixes' ? 'text-yellow-600' : 
                                                       'text-red-600'}">
                        ${results.finalVerdict.status}
                    </span>
                </div>
                ${failedChecks.length > 0 ? `
                    <div class="mt-4">
                        <h4 class="text-sm font-medium text-gray-900  mb-2">Suggested Fixes:</h4>
                        <ul class="list-disc list-inside space-y-1">
                            ${failedChecks.map(check => `
                                <li class="text-sm text-gray-600 dark:text-gray-300">
                                    ${check.item.label}: ${check.feedback}
                                </li>
                            `).join('')}
                        </ul>
                    </div>
                ` : ''}
            </div>
        `;

        resultsContainer.innerHTML = html;
    }
};

// File Upload Handler
document.getElementById('codeFileInput').addEventListener('change', async (e) => {
    const file = e.target.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = async (event) => {
        const code = event.target.result;
        const results = await prebuiltValidator.validateCode(code);
        prebuiltValidator.displayResults(results);
    };
    reader.readAsText(file);
});

// Validate Button Handler
document.getElementById('validatePrebuilt').addEventListener('click', async () => {
    const fileInput = document.getElementById('codeFileInput');
    if (!fileInput.files.length) {
        alert('Please select a file first');
        return;
    }

    const file = fileInput.files[0];
    const reader = new FileReader();
    reader.onload = async (event) => {
        const code = event.target.result;
        const results = await prebuiltValidator.validateCode(code);
        prebuiltValidator.displayResults(results);
    };
    reader.readAsText(file);
});

// Export Results Handler
document.getElementById('exportPrebuiltValidation').addEventListener('click', () => {
    const resultsContainer = document.getElementById('prebuiltValidationResults');
    const results = {
        timestamp: new Date().toISOString(),
        moduleDetails: {
            name: resultsContainer.querySelector('.module-details .name')?.textContent,
            layout: resultsContainer.querySelector('.module-details .layout')?.textContent
        },
        checklistResults: Array.from(resultsContainer.querySelectorAll('.checklist-item')).map(item => ({
            label: item.querySelector('.label').textContent,
            status: item.querySelector('.status').textContent,
            feedback: item.querySelector('.feedback').textContent
        })),
        finalVerdict: {
            status: resultsContainer.querySelector('.final-verdict .status').textContent,
            message: resultsContainer.querySelector('.final-verdict .message').textContent
        }
    };

    const jsonContent = JSON.stringify(results, null, 2);
    const blob = new Blob([jsonContent], { type: 'application/json' });
    const url = window.URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'prebuilt-validation-results.json';
    a.click();
});

// Close Prebuilt Validator Panel
document.getElementById('closePrebuiltValidator').addEventListener('click', () => {
    const validatorPanel = document.getElementById('prebuiltValidatorPanel');
    if (validatorPanel) {
        validatorPanel.classList.add('translate-x-full');
        
        // Clear the file input
        const fileInput = document.getElementById('codeFileInput');
        if (fileInput) {
            fileInput.value = '';
        }
        
        // Clear validation results
        const resultsContainer = document.getElementById('prebuiltValidationResults');
        if (resultsContainer) {
            resultsContainer.innerHTML = '';
        }
    }
});

// Open Prebuilt Validator
function openPrebuiltValidator(itemName) {
    const validatorPanel = document.getElementById('prebuiltValidatorPanel');
    if (!validatorPanel) return;

    // Set the current item name in the validator panel
    const panelTitle = validatorPanel.querySelector('h2');
    if (panelTitle) {
        panelTitle.textContent = `Prebuilt Validator - ${itemName}`;
    }
    
    // Show the validator panel
    validatorPanel.classList.remove('translate-x-full');
    
    // Clear previous results
    const resultsContainer = document.getElementById('prebuiltValidationResults');
    if (resultsContainer) {
        resultsContainer.innerHTML = '';
    }
    
    // Focus the file input
    const fileInput = document.getElementById('codeFileInput');
    if (fileInput) {
        fileInput.click();
    }
}

// HTML to Blade Converter System
const bladeConverter = {
    // Convert HTML to Blade
    convertToBlade(html, options) {
        let bladeCode = '{{-- Auto-generated from dynamic HTML stored in DB --}}\n\n';
        
        // Add layout extension if needed
        if (options.useLayout) {
            bladeCode += "@extends('layouts.master')\n\n";
            bladeCode += "@section('content')\n";
        }

        // Process HTML
        let processedHtml = html;

        // Replace common patterns with Blade components
        if (options.reuseComponents) {
            processedHtml = this.replaceWithComponents(processedHtml);
        }

        // Add form validation
        if (options.addValidation) {
            processedHtml = this.addFormValidation(processedHtml);
        }

        // Add the processed HTML
        bladeCode += processedHtml;

        // Close section if using layout
        if (options.useLayout) {
            bladeCode += "\n@endsection";
        }

        return bladeCode;
    },

    // Replace common patterns with Blade components
    replaceWithComponents(html) {
        let processed = html;

        // Replace inputs
        processed = processed.replace(/<input([^>]+)>/g, (match, attrs) => {
            const nameMatch = attrs.match(/name="([^"]+)"/);
            const typeMatch = attrs.match(/type="([^"]+)"/);
            const labelMatch = attrs.match(/placeholder="([^"]+)"/);
            
            if (nameMatch) {
                const name = nameMatch[1];
                const type = typeMatch ? typeMatch[1] : 'text';
                const label = labelMatch ? labelMatch[1] : name;
                
                return `@include('components.input', ['name' => '${name}', 'type' => '${type}', 'label' => '${label}'])`;
            }
            return match;
        });

        // Replace buttons
        processed = processed.replace(/<button([^>]*)>([^<]+)<\/button>/g, (match, attrs, text) => {
            const typeMatch = attrs.match(/type="([^"]+)"/);
            const type = typeMatch ? typeMatch[1] : 'button';
            return `@include('components.button', ['label' => '${text.trim()}', 'type' => '${type}'])`;
        });

        // Replace forms
        processed = processed.replace(/<form([^>]*)>/g, (match, attrs) => {
            const actionMatch = attrs.match(/action="([^"]+)"/);
            const methodMatch = attrs.match(/method="([^"]+)"/);
            
            let formStart = '<form';
            if (actionMatch) {
                formStart += ` action="{{ route('${actionMatch[1]}') }}"`;
            }
            if (methodMatch) {
                formStart += ` method="${methodMatch[1]}"`;
            }
            formStart += '>\n@csrf\n';
            
            if (methodMatch && methodMatch[1].toUpperCase() !== 'GET') {
                formStart += `@method('${methodMatch[1].toUpperCase()}')\n`;
            }
            
            return formStart;
        });

        return processed;
    },

    // Add form validation
    addFormValidation(html) {
        let processed = html;

        // Add validation error display
        processed = processed.replace(/<input([^>]+)>/g, (match, attrs) => {
            const nameMatch = attrs.match(/name="([^"]+)"/);
            if (nameMatch) {
                const name = nameMatch[1];
                return `${match}\n@error('${name}')\n    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>\n@enderror`;
            }
            return match;
        });

        return processed;
    }
};

// Open Blade Converter
function openBladeConverter(itemName) {
    const modal = document.getElementById('bladeConverterModal');
    const moduleNameInput = document.getElementById('bladeModuleName');
    const htmlInput = document.getElementById('htmlInput');
    
    // Set module name
    moduleNameInput.value = itemName;
    
    // Show modal
    modal.classList.remove('hidden');
    
    // Focus HTML input
    htmlInput.focus();
}

// Close Blade Converter
document.getElementById('closeBladeConverter').addEventListener('click', () => {
    const modal = document.getElementById('bladeConverterModal');
    if (modal) {
        modal.classList.add('hidden');
        
        // Clear inputs
        const htmlInput = document.getElementById('htmlInput');
        const bladeOutput = document.getElementById('bladeOutput');
        const moduleNameInput = document.getElementById('bladeModuleName');
        
        if (htmlInput) htmlInput.value = '';
        if (bladeOutput) bladeOutput.textContent = '';
        if (moduleNameInput) moduleNameInput.value = '';
    }
});

// Convert HTML to Blade
document.getElementById('htmlInput').addEventListener('input', (e) => {
    const options = {
        useLayout: document.getElementById('useLayout').checked,
        reuseComponents: document.getElementById('reuseComponents').checked,
        addValidation: document.getElementById('addValidation').checked
    };
    
    const bladeOutput = bladeConverter.convertToBlade(e.target.value, options);
    document.getElementById('bladeOutput').textContent = bladeOutput;
});

// Copy Blade Output
document.getElementById('copyBladeOutput').addEventListener('click', () => {
    const output = document.getElementById('bladeOutput').textContent;
    navigator.clipboard.writeText(output).then(() => {
        alert('Blade code copied to clipboard!');
    });
});

// Save Blade File
document.getElementById('saveBladeFile').addEventListener('click', () => {
    const moduleName = document.getElementById('bladeModuleName').value;
    const category = document.getElementById('bladeCategory').value;
    const bladeCode = document.getElementById('bladeOutput').textContent;
    
    // Here you would implement the actual file saving logic
    console.log('Saving Blade file:', {
        moduleName,
        category,
        bladeCode
    });
    
    // Add to activity log
    activityLog.unshift({
        timestamp: new Date().toLocaleString(),
        action: `Blade file generated for ${moduleName}`,
        type: 'blade'
    });
    renderActivityLog();
    
    // Close modal
    document.getElementById('bladeConverterModal').classList.add('hidden');
});

// Add click outside to close for both modals
document.addEventListener('click', (e) => {
    // Close Blade Converter Modal
    const bladeModal = document.getElementById('bladeConverterModal');
    if (bladeModal && !bladeModal.classList.contains('hidden')) {
        const modalContent = bladeModal.querySelector('.bg-white');
        if (modalContent && !modalContent.contains(e.target) && !e.target.closest('button[onclick*="openBladeConverter"]')) {
            bladeModal.classList.add('hidden');
            // Clear inputs
            const htmlInput = document.getElementById('htmlInput');
            const bladeOutput = document.getElementById('bladeOutput');
            const moduleNameInput = document.getElementById('bladeModuleName');
            if (htmlInput) htmlInput.value = '';
            if (bladeOutput) bladeOutput.textContent = '';
            if (moduleNameInput) moduleNameInput.value = '';
        }
    }

    // Close Prebuilt Validator Panel
    const validatorPanel = document.getElementById('prebuiltValidatorPanel');
    if (validatorPanel && !validatorPanel.classList.contains('translate-x-full')) {
        const panelContent = validatorPanel.querySelector('.p-6');
        if (panelContent && !panelContent.contains(e.target) && !e.target.closest('button[onclick*="openPrebuiltValidator"]')) {
            validatorPanel.classList.add('translate-x-full');
            // Clear the file input
            const fileInput = document.getElementById('codeFileInput');
            if (fileInput) fileInput.value = '';
            // Clear validation results
            const resultsContainer = document.getElementById('prebuiltValidationResults');
            if (resultsContainer) resultsContainer.innerHTML = '';
        }
    }
});

// Add escape key to close for both modals
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') {
        // Close Blade Converter Modal
        const bladeModal = document.getElementById('bladeConverterModal');
        if (bladeModal && !bladeModal.classList.contains('hidden')) {
            bladeModal.classList.add('hidden');
            // Clear inputs
            const htmlInput = document.getElementById('htmlInput');
            const bladeOutput = document.getElementById('bladeOutput');
            const moduleNameInput = document.getElementById('bladeModuleName');
            if (htmlInput) htmlInput.value = '';
            if (bladeOutput) bladeOutput.textContent = '';
            if (moduleNameInput) moduleNameInput.value = '';
        }

        // Close Prebuilt Validator Panel
        const validatorPanel = document.getElementById('prebuiltValidatorPanel');
        if (validatorPanel && !validatorPanel.classList.contains('translate-x-full')) {
            validatorPanel.classList.add('translate-x-full');
            // Clear the file input
            const fileInput = document.getElementById('codeFileInput');
            if (fileInput) fileInput.value = '';
            // Clear validation results
            const resultsContainer = document.getElementById('prebuiltValidationResults');
            if (resultsContainer) resultsContainer.innerHTML = '';
        }
    }
}); 