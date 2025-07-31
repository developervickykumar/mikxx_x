@extends('layouts.master')

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.5.1/axios.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.38.0/min/vs/loader.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <style>
        #fileTree {
            width: 25%;
            height: 600px;
            overflow: auto;
            border-right: 1px solid #ccc;
            padding: 10px;
        }
        #editorWrap {
            width: 75%;
            padding-left: 15px;
        }
        .tree-folder ul {
            list-style-type: none;
            margin-left: 15px;
            padding-left: 15px;
            border-left: 1px dashed #ccc;
        }
         .tree-folder ul {
            list-style-type: none;
            margin-left: 15px;
            padding-left: 15px;
            border-left: 1px dashed #ccc;
        }
        .chevron {
            cursor: pointer;
            user-select: none;
            font-size: 14px;
            margin-right: 4px;
        }
        .tree-list {
            display: none;
        }
        .tree-list.show {
            display: block;
        }
    </style>
    
 @section('content')
    <div class="d-flex">
        <div id="fileTree">
            <input type="text" class="form-control mb-2" id="searchInput" placeholder="Search..." onkeyup="filterTree()">
            <div id="treeContent"></div>
        </div>
        <div id="editorWrap">
            <div class="mb-2">
                <input type="text" id="filePath" class="form-control d-inline-block" style="width:60%">
                <button class="btn btn-primary" onclick="loadFile()">Load</button>
                <button class="btn btn-success" onclick="saveFile()">Save</button>
                <button onclick="loadHistoryList()">View History</button>
                <select id="historyDropdown" onchange="loadHistoryVersion(this.value)"></select>

                <button class="btn btn-secondary" onclick="newFilePrompt()">New</button>
            </div>
            <div id="editor" style="height:600px;"></div>
        </div>
    </div>

    <script>
    let editor;

    require.config({ paths: { 'vs': 'https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.38.0/min/vs' } });
    require(["vs/editor/editor.main"], function () {
        editor = monaco.editor.create(document.getElementById('editor'), {
            value: '',
            language: 'php',
            theme: 'vs-dark'
        });
        fetchTree();
    });

    function fetchTree() {
        axios.get("{{ route('file.manager.tree') }}").then(res => {
            document.getElementById('treeContent').innerHTML = renderTree(res.data);
            attachToggleEvents();
        });
    }
function renderTree(data) {
    let html = '';
    let first = true;
    for (const [root, files] of Object.entries(data)) {
        html += `
            <div class="tree-folder">
                <div class="d-flex align-items-center folder-toggle" data-expanded="${first}">
                    <span class="chevron">${first ? '▼' : '▶'}</span>
                    <strong>${root}</strong>
                </div>
                <ul class="tree-list ${first ? 'show' : ''}">
                    ${walk(files, first)}
                </ul>
            </div>`;
        first = false;
    }
    return html;
}

function walk(arr, expand = false) {
    return arr.map(i => {
        if (i.type === 'dir') {
            const id = 'id_' + Math.random().toString(36).substr(2, 9);
            return `
                <li>
                    <div class="d-flex align-items-center folder-toggle" data-expanded="false">
                        <span class="chevron">▶</span>
                        <strong>${i.name}</strong>
                    </div>
                    <ul class="tree-list">
                        ${walk(i.children)}
                    </ul>
                </li>`;
        } else {
            return `<li><a href="#" onclick="selectFile('${i.path}')">📄 ${i.name}</a></li>`;
        }
    }).join('');
}

function attachToggleEvents() {
    document.querySelectorAll('.folder-toggle').forEach(toggle => {
        toggle.addEventListener('click', function () {
            const chevron = this.querySelector('.chevron');
            const ul = this.nextElementSibling;
            const expanded = this.getAttribute('data-expanded') === 'true';

            if (ul && ul.classList.contains('tree-list')) {
                ul.classList.toggle('show');
                this.setAttribute('data-expanded', !expanded);
                chevron.textContent = expanded ? '▶' : '▼';
            }
        });
    });
}

    function selectFile(path) {
        document.getElementById('filePath').value = path;
        loadFile();
    }

    function loadFile() {
        const path = document.getElementById('filePath').value;
        axios.get("{{ route('file.manager.load') }}", { params: { path } })
            .then(res => editor.setValue(res.data.content))
            .catch(err => alert('Failed to load'));
    }

    function saveFile() {
        const path = document.getElementById('filePath').value;
        const content = editor.getValue();
        axios.post("{{ route('file.manager.save') }}", { path, content })
            .then(res => alert('Saved!'))
            .catch(err => alert('Save failed'));
    }

    function newFilePrompt() {
        const path = prompt("Enter full relative path to create (e.g., resources/views/test.blade.php)");
        const type = path && path.endsWith('/') ? 'dir' : 'file';
        if (!path) return;
        axios.post("{{ route('file.manager.create') }}", { path, type })
            .then(() => { alert('Created'); fetchTree(); })
            .catch(() => alert('Create failed'));
    }

    function filterTree() {
        const input = document.getElementById('searchInput').value.toLowerCase();
        const tree = document.getElementById('treeContent');
        tree.querySelectorAll("li, .folder-toggle").forEach(el => {
            const text = el.textContent.toLowerCase();
            el.style.display = text.includes(input) ? '' : 'none';
        });
    }

    function loadHistoryList() {
        const path = document.getElementById('filePath').value;
        axios.get("{{ route('file.manager.history') }}", { params: { path } })
            .then(res => {
                let dropdown = document.getElementById('historyDropdown');
                dropdown.innerHTML = '<option value="">Select Version</option>';
                res.data.forEach(item => {
                    dropdown.innerHTML += `<option value="${item.file}">${item.timestamp}</option>`;
                });
            });
    }

    function loadHistoryVersion(file) {
        if (!file) return;
        axios.get("{{ route('file.manager.history.load') }}", { params: { file } })
            .then(res => editor.setValue(res.data.content));
    }

    </script>
@endsection