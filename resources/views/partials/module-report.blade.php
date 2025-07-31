 
    <style>
        

        .card {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        

        .input,
        select,
        textarea {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        .badge {
            padding: 4px 8px;
            border-radius: 5px;
            font-size: 12px;
            color: #fff;
        }

        .high {
            background: red;
        }

        .moderate {
            background: orange;
        }

        .none {
            background: gray;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            padding: 10px;
            border-bottom: 1px solid #ccc;
        }

        .popup-bg,
        .edit-modal {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 100;
            justify-content: center;
            align-items: center;
        }

        .popup-box {
            background: white;
            padding: 25px;
            border-radius: 10px;
            width: 500px;
            position: relative;
        }

        .close-btn {
            position: absolute;
            right: 15px;
            top: 10px;
            cursor: pointer;
            color: red;
            font-size: 18px;
        }

        ul {
            padding-left: 20px;
        }

        .report-row+.title {
            margin-top: 20px;
        }

        .title:not(.card .title) {
            font-size: 16px;
            font-weight: bold;
            margin: 20px;
            color: #4d42c3;
        }


        .flex {
            display: flex;
            gap: 10px;
            align-items: center;
            flex-wrap: wrap;
        }

        .report-row {
            /* display: flex;
            gap: 20px;
            flex-wrap: wrap; */
            display: inline-flex;
            margin-top: 10px;
        }

        .report-item {
            padding:  5px;
            border-radius: 8px;
            font-size: 14px;
        }
    </style>
 

    <!-- Add Button -->
    <div class=" bg-white p-3 rounded-3 row">
        <div class="title">Module Improvement Panel</div>

        <div class="flex col-md-12 py-3 bg-secondary-subtle">
            <select id="filterType" class="input" style="max-width: 200px;" onchange="applyFilters()">
                <option value="">All Types</option>
                <option>Bugs</option>
                <option>Improvements</option>
                <option>Integrations</option>
                <option>Notes</option>
                <option>Prompt</option>
                <option>Others</option>
            </select>
            <select id="filterStatus" class="input" style="max-width: 200px;" onchange="applyFilters()">
                <option value="">All Status</option>
                <option>Pending</option>
                <option>Done</option>
            </select>
            <select id="filterPriority" class="input" style="max-width: 200px;" onchange="applyFilters()">
                <option value="">All Priority</option>
                <option>High</option>
                <option>Moderate</option>
                <option>None</option>
            </select>
            <button type="button" class="btn btn-primary" onclick="showPopup()">+ Add Improvement</button>
        </div>

        <div class="col-md-6 ">
            <div class="report-row" id="reportSummary">
                <!-- Auto filled via JS -->
 
            </div>
        </div>
    </div>
 
    <!-- Improvement List -->
    <div class="card">
        <div class="title">Submitted Improvements</div>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Type</th>
                    <th>Description</th>
                    <th>Priority</th>
                    <th>Status</th>
                    <th>Developer</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="listTableBody"></tbody>
        </table>
    </div>

    <!-- Add Improvement Popup -->
    <div class="popup-bg" id="popupForm">
        <div class="popup-box">
            <div class="title">Add Improvements</div>
            <span class="close-btn" onclick="hidePopup()">×</span>
            <div class="flex">
                <label><input type="radio" name="type" value="Bugs"> Bugs</label>
                <label><input type="radio" name="type" value="Improvements"> Improvements</label>
                <label><input type="radio" name="type" value="Integrations"> Integrations</label>
                <label><input type="radio" name="type" value="Notes"> Notes</label>
                <label><input type="radio" name="type" value="Prompt"> Prompt</label>
                <label><input type="radio" name="type" value="Others"> Others</label>
            </div>
            <div class="flex">
                <textarea id="descInput" class="input" rows="4" placeholder="Enter improvement point..."></textarea>
                <button type="button" class="btn btn-primary" onclick="addPoint()">+ Add Point</button>
            </div>
            <ul id="pointList"></ul>
            <select id="assignTo" class="input">
                <option value="">-- Assign Developer --</option>
                <option>Developer 1</option>
                <option>Developer 2</option>
                <option>Developer 3</option>
                <option>Developer 4</option>
            </select>
            <button type="button" class="btn btn-primary" onclick="submitAll()">Submit All</button>
        </div>
    </div>

    <!-- Edit Improvement Modal -->
    <div class="edit-modal popup-bg" id="editModal">
        <div class="popup-box">
            <div class="title">Edit Improvement</div>
            <span class="close-btn" onclick="closeEditModal()">×</span>
            <input id="editDesc" class="input" placeholder="Edit description" />
            <select id="editType" class="input">
                <option>Bugs</option>
                <option>Improvements</option>
                <option>Integrations</option>
                <option>Notes</option>
                <option>Prompt</option>
                <option>Others</option>
            </select>
            <select id="editStatus" class="input">
                <option>Pending</option>
                <option>Done</option>
            </select>
            <select id="editDev" class="input">
                <option>Developer 1</option>
                <option>Developer 2</option>
                <option>Developer 3</option>
                <option>Developer 4</option>
            </select>
            <button type="button" class="btn btn-primary" onclick="saveEdit()">Save</button>
        </div>
    </div>

