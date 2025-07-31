<style>
    #checklistDrawer{
        top:8%;
    }
</style>

<div class="flex h-[calc(100vh-4rem)]">


     
    <!-- START: Checklist Drawer -->
    <div id="checklistDrawer"
        class="z-2 fixed inset-y-0 right-0 w-96 bg-white dark:bg-gray-800 shadow-lg transform translate-x-full transition-transform duration-300 ease-in-out">
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-lg font-semibold text-gray-900 ">Module Validation Checklist</h2>
                <button id="closeChecklist"
                    class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- Progress Bar -->
            <div class="mb-6">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Validation Progress</span>
                    <span id="checklistProgress" class="text-sm font-medium text-indigo-600">0%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                    <div id="progressBar" class="bg-indigo-600 h-2.5 rounded-full" style="width: 0%"></div>
                </div>
            </div>

            <!-- AI Feedback Section -->
            <div id="aiFeedback" class="mb-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg hidden">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i class="fas fa-robot text-indigo-600"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-gray-900 ">AI Validation Feedback</h3>
                        <p id="aiFeedbackText" class="mt-1 text-sm text-gray-500 dark:text-gray-300"></p>
                    </div>
                </div>
            </div>

            <div class="space-y-4">
                <div id="checklistContent" class="space-y-4">
                    <!-- Checklist items will be dynamically populated -->
                </div>
                <div class="pt-4 border-t border-gray-200 dark:border-gray-700 space-y-4">
                    <button id="validateWithAI"
                        class="w-full bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                        <i class="fas fa-robot mr-2"></i>Validate with AI
                    </button>
                    <button id="exportChecklist"
                        class="w-full bg-gray-100 text-gray-700 px-4 py-2 rounded hover:bg-gray-200">
                        <i class="fas fa-download mr-2"></i>Export Checklist
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- START: Prompt Drawer -->
    <div id="promptDrawer"
        class="fixed inset-y-0 right-0 w-96 bg-white dark:bg-gray-800 shadow-lg transform translate-x-full transition-transform duration-300 ease-in-out">
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-lg font-semibold text-gray-900 ">Prompt Builder</h2>
                <button id="closeDrawer"
                    class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Item Name</label>
                    <input type="text" id="itemName"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Detected Type</label>
                    <input type="text" id="itemType"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                        readonly>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Suggested Prompt</label>
                    <textarea id="suggestedPrompt" rows="4"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                </div>
                <div class="flex space-x-4">
                    <button id="pickComponent"
                        class="flex-1 bg-gray-100 text-gray-700 px-4 py-2 rounded hover:bg-gray-200">
                        <i class="fas fa-puzzle-piece mr-2"></i>Pick Component
                    </button>
                    <button id="copyPrompt"
                        class="flex-1 bg-gray-100 text-gray-700 px-4 py-2 rounded hover:bg-gray-200">
                        <i class="fas fa-copy mr-2"></i>Copy Prompt
                    </button>
                    <button id="sendToChatGPT"
                        class="flex-1 bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                        <i class="fas fa-paper-plane mr-2"></i>Send to ChatGPT
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- START: Component Picker Modal -->
    <div id="componentPickerModal" class="fixed inset-0 bg-black bg-opacity-50 hidden">
        <div class="fixed inset-0 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-2xl w-full max-h-[80vh] overflow-y-auto">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 ">Pick a Component</h3>
                        <button id="closeComponentPicker"
                            class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4" id="componentGrid">
                        <!-- Components will be dynamically populated -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- START: Improvement Tracking Modal -->
    <div id="improvementModal" class="fixed inset-0 bg-black bg-opacity-50 hidden">
        <div class="fixed inset-0 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-2xl w-full max-h-[80vh] overflow-y-auto">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 ">Areas of Improvement</h3>
                        <button id="closeImprovementModal"
                            class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    <!-- Improvement Categories -->
                    <div class="space-y-6">
                        <!-- UI/UX Improvements -->
                        <div class="improvement-category">
                            <h4 class="text-md font-medium text-gray-900  mb-3">
                                <i class="fas fa-paint-brush mr-2"></i>UI/UX Improvements
                            </h4>
                            <div class="space-y-2">
                                <div class="flex items-center">
                                    <input type="checkbox" id="ui1"
                                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    <label for="ui1" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                                        Add keyboard shortcuts for common actions
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" id="ui2"
                                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    <label for="ui2" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                                        Implement drag-and-drop for checklist items
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" id="ui3"
                                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    <label for="ui3" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                                        Add tooltips for better user guidance
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- AI Integration Improvements -->
                        <div class="improvement-category">
                            <h4 class="text-md font-medium text-gray-900  mb-3">
                                <i class="fas fa-robot mr-2"></i>AI Integration Improvements
                            </h4>
                            <div class="space-y-2">
                                <div class="flex items-center">
                                    <input type="checkbox" id="ai1"
                                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    <label for="ai1" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                                        Implement real-time AI suggestions
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" id="ai2"
                                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    <label for="ai2" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                                        Add AI-powered code review
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" id="ai3"
                                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    <label for="ai3" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                                        Implement automated test generation
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Performance Improvements -->
                        <div class="improvement-category">
                            <h4 class="text-md font-medium text-gray-900  mb-3">
                                <i class="fas fa-tachometer-alt mr-2"></i>Performance Improvements
                            </h4>
                            <div class="space-y-2">
                                <div class="flex items-center">
                                    <input type="checkbox" id="perf1"
                                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    <label for="perf1" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                                        Implement lazy loading for large lists
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" id="perf2"
                                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    <label for="perf2" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                                        Add caching for AI responses
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" id="perf3"
                                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    <label for="perf3" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                                        Optimize checklist rendering
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Feature Improvements -->
                        <div class="improvement-category">
                            <h4 class="text-md font-medium text-gray-900  mb-3">
                                <i class="fas fa-star mr-2"></i>Feature Improvements
                            </h4>
                            <div class="space-y-2">
                                <div class="flex items-center">
                                    <input type="checkbox" id="feat1"
                                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    <label for="feat1" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                                        Add version control integration
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" id="feat2"
                                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    <label for="feat2" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                                        Implement team collaboration features
                                    </label>
                                </div>
                                <div class="flex items-center">
                                    <input type="checkbox" id="feat3"
                                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    <label for="feat3" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                                        Add custom checklist templates
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-6 flex justify-end space-x-4">
                        <button id="exportImprovements"
                            class="bg-gray-100 text-gray-700 px-4 py-2 rounded hover:bg-gray-200">
                            <i class="fas fa-download mr-2"></i>Export List
                        </button>
                        <button id="saveImprovements"
                            class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                            <i class="fas fa-save mr-2"></i>Save Changes
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- START: AI Module Validator Modal -->
    <div id="validatorModal" class="fixed inset-0 bg-black bg-opacity-50 hidden">
        <div class="fixed inset-0 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-3xl w-full max-h-[80vh] overflow-y-auto">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 ">AI Module Validator</h3>
                        <button id="closeValidatorModal"
                            class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    <!-- Module Info -->
                    <div class="mb-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Module
                                    Name</label>
                                <input type="text" id="moduleName"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Category</label>
                                <select id="moduleCategory"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="form">Form</option>
                                    <option value="page">Page</option>
                                    <option value="tool">Tool</option>
                                    <option value="downloader">Downloader</option>
                                    <option value="integration">Integration</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Validation Results -->
                    <div id="validationResults" class="space-y-4">
                        <!-- Results will be dynamically populated -->
                    </div>

                    <!-- Final Verdict -->
                    <div id="finalVerdict" class="mt-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg hidden">
                        <h4 class="text-md font-medium text-gray-900  mb-2">Final Verdict</h4>
                        <div class="flex items-center space-x-2">
                            <span id="verdictIcon" class="text-2xl"></span>
                            <span id="verdictText" class="text-lg font-semibold"></span>
                        </div>
                        <div id="suggestedFixes" class="mt-4 space-y-2">
                            <!-- Suggested fixes will be dynamically populated -->
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-6 flex justify-end space-x-4">
                        <button id="exportValidation"
                            class="bg-gray-100 text-gray-700 px-4 py-2 rounded hover:bg-gray-200">
                            <i class="fas fa-download mr-2"></i>Export Report
                        </button>
                        <button id="runValidation"
                            class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                            <i class="fas fa-robot mr-2"></i>Run Validation
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- START: AI Feedback Panel -->
    <div id="aiFeedbackPanel"
        class="fixed inset-y-0 right-0 w-96 bg-white dark:bg-gray-800 shadow-lg transform translate-x-full transition-transform duration-300 ease-in-out">
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-lg font-semibold text-gray-900 ">AI Analysis</h2>
                <button id="closeAIFeedback"
                    class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- AI Analysis Tabs -->
            <div class="mb-6">
                <div class="border-b border-gray-200 dark:border-gray-700">
                    <nav class="flex space-x-4" aria-label="Tabs">
                        <button
                            class="ai-tab active px-3 py-2 text-sm font-medium text-indigo-600 border-b-2 border-indigo-600"
                            data-tab="analysis">
                            Analysis
                        </button>
                        <button
                            class="ai-tab px-3 py-2 text-sm font-medium text-gray-500 hover:text-gray-700 border-b-2 border-transparent"
                            data-tab="suggestions">
                            Suggestions
                        </button>
                        <button
                            class="ai-tab px-3 py-2 text-sm font-medium text-gray-500 hover:text-gray-700 border-b-2 border-transparent"
                            data-tab="code">
                            Code Examples
                        </button>
                    </nav>
                </div>
            </div>

            <!-- Analysis Content -->
            <div id="analysisContent" class="space-y-4">
                <!-- Content will be dynamically populated -->
            </div>

            <!-- Suggestions Content -->
            <div id="suggestionsContent" class="space-y-4 hidden">
                <!-- Content will be dynamically populated -->
            </div>

            <!-- Code Examples Content -->
            <div id="codeContent" class="space-y-4 hidden">
                <!-- Content will be dynamically populated -->
            </div>

            <!-- Action Buttons -->
            <div class="mt-6 space-y-4">
                <button id="regenerateAnalysis"
                    class="w-full bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                    <i class="fas fa-sync-alt mr-2"></i>Regenerate Analysis
                </button>
                <button id="exportAnalysis"
                    class="w-full bg-gray-100 text-gray-700 px-4 py-2 rounded hover:bg-gray-200">
                    <i class="fas fa-download mr-2"></i>Export Analysis
                </button>
            </div>
        </div>
    </div>

    <!-- START: Prebuilt Code Validator Panel -->
    <div id="prebuiltValidatorPanel"
        class="fixed inset-y-0 right-0 w-96 bg-white dark:bg-gray-800 shadow-lg transform translate-x-full transition-transform duration-300 ease-in-out">
        <div class="p-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-lg font-semibold text-gray-900 ">Prebuilt Code Validator</h2>
                <button id="closePrebuiltValidator"
                    class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <!-- File Upload Section -->
            <div class="mb-6">
                <div class="border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg p-6 text-center">
                    <input type="file" id="codeFileInput" class="hidden" accept=".html,.blade.php">
                    <label for="codeFileInput" class="cursor-pointer">
                        <i class="fas fa-upload text-3xl text-gray-400 mb-2"></i>
                        <p class="text-sm text-gray-600 dark:text-gray-400">Drop HTML/Blade files here or click to
                            upload</p>
                    </label>
                </div>
            </div>

            <!-- Validation Results -->
            <div id="prebuiltValidationResults" class="space-y-4">
                <!-- Results will be dynamically populated -->
            </div>

            <!-- Action Buttons -->
            <div class="mt-6 space-y-4">
                <button id="validatePrebuilt"
                    class="w-full bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                    <i class="fas fa-check-circle mr-2"></i>Validate Code
                </button>
                <button id="exportPrebuiltValidation"
                    class="w-full bg-gray-100 text-gray-700 px-4 py-2 rounded hover:bg-gray-200">
                    <i class="fas fa-download mr-2"></i>Export Results
                </button>
            </div>
        </div>
    </div>

    <!-- START: HTML to Blade Converter Modal -->
    <div id="bladeConverterModal" class="fixed inset-0 bg-black bg-opacity-50 hidden">
        <div class="fixed inset-0 flex items-center justify-center p-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-xl max-w-4xl w-full max-h-[80vh] overflow-y-auto">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 ">HTML to Blade Converter</h3>
                        <button id="closeBladeConverter"
                            class="text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>

                    <!-- Module Info -->
                    <div class="mb-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Module
                                    Name</label>
                                <input type="text" id="bladeModuleName"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300">Category</label>
                                <select id="bladeCategory"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="form">Form</option>
                                    <option value="page">Page</option>
                                    <option value="tool">Tool</option>
                                    <option value="popup">Popup</option>
                                    <option value="partial">Partial</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- HTML Input -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">HTML Code</label>
                        <textarea id="htmlInput" rows="10"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 font-mono text-sm"></textarea>
                    </div>

                    <!-- Conversion Options -->
                    <div class="mb-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                        <h4 class="text-sm font-medium text-gray-900  mb-3">Conversion Options</h4>
                        <div class="space-y-2">
                            <div class="flex items-center">
                                <input type="checkbox" id="useLayout"
                                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                    checked>
                                <label for="useLayout" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                                    Use Master Layout
                                </label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" id="reuseComponents"
                                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                    checked>
                                <label for="reuseComponents" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                                    Reuse Existing Components
                                </label>
                            </div>
                            <div class="flex items-center">
                                <input type="checkbox" id="addValidation"
                                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                    checked>
                                <label for="addValidation" class="ml-2 text-sm text-gray-700 dark:text-gray-300">
                                    Add Form Validation
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Blade Output -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Blade
                            Output</label>
                        <div id="bladeOutput"
                            class="w-full rounded-md border border-gray-300 bg-gray-50 dark:bg-gray-900 p-4 font-mono text-sm overflow-x-auto">
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-end space-x-4">
                        <button id="copyBladeOutput"
                            class="bg-gray-100 text-gray-700 px-4 py-2 rounded hover:bg-gray-200">
                            <i class="fas fa-copy mr-2"></i>Copy Output
                        </button>
                        <button id="saveBladeFile"
                            class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                            <i class="fas fa-save mr-2"></i>Save Blade File
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Mobile Menu Button -->
<button id="mobileMenuButton"
    class="md:hidden fixed bottom-4 right-4 bg-indigo-600 text-white p-3 rounded-full shadow-lg">
    <i class="fas fa-bars"></i>
</button>