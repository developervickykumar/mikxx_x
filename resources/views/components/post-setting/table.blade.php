<div class="setting-block functionality-settings" data-type="table" style="display: none;">

<div class="d-flex">

    <style>
    table {
        border-collapse: separate;
        width: 90%;
        /* margin: 20px auto; */
        border-spacing: 5px;
    }

    th {
        background-color: #d2d2d2 !important;
        color: white
    }



    th,
    td {
        border: 1px solid #ffffff;
        padding: 8px;
        text-align: left;
        height: 20px;
        /* ✅ Fixed height */
        width: 250px;
    }

    th[contenteditable],
    td[contenteditable] {
        background-color: #f1f1f1;
        color: #8b8b8b;
    }

    button {
        padding: 6px 12px;
        margin: 5px;
        cursor: pointer;
    }

    .controls {
        margin: 10px;
    }

    input.form-control {
        padding: 6px;
        margin-bottom: 10px;
    }

    .form-table input {
        min-width: 120px;
    }

    .barcode-input {
        width: 150px;
    }

    th,
    td {
        vertical-align: middle !important;
    }

    .dropdown-checkboxes {
        max-height: 200px;
        overflow-y: auto;
    }

    .form-table input {
        min-width: 120px;
    }
    </style>

    <div class="m-2">

        <input class="form-control" type="text" placeholder="Add Heading">

        <table id="customTable">
            <thead>
                <tr id="tableHeaders">
                    <th contenteditable="true">Field 1</th>
                    <th contenteditable="true">Field 2</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td contenteditable="true"></td>
                    <td contenteditable="true"></td>
                </tr>
            </tbody>
        </table>

    </div>

    <div class="controls">
        <button class="btn" onclick="addColumn()">
            <i class="mdi mdi-plus-box-outline fs-6 icon-choice"></i> Add
        </button>
        <button class="btn" onclick="deleteLastColumn()">
            <i class="bx bx-trash"></i> Delete
        </button>
    </div>

    <script>
    function addColumn() {
        const headerRow = document.getElementById("tableHeaders");
        const newTh = document.createElement("th");
        newTh.contentEditable = "true";
        newTh.innerText = ""; // Empty heading to be filled manually
        headerRow.appendChild(newTh); // ✅ Append at the end

        // Add a new editable cell at the end of each row
        const rows = document.querySelectorAll("#customTable tbody tr");
        rows.forEach(row => {
            const newCell = document.createElement("td");
            newCell.contentEditable = "true";
            newCell.innerText = ""; // Empty cell for manual entry
            row.appendChild(newCell);
        });

        // Optional: Clear the input field, if it's still visible
        document.getElementById("newColName").value = "";
    }


    function deleteLastColumn() {
        const headers = document.querySelectorAll("#tableHeaders th");
        if (headers.length <= 1) {
            alert("You must have at least one column.");
            return;
        }

        if (!confirm("Are you sure you want to delete the last column?")) return;

        // Remove last header
        headers[headers.length - 1].remove();

        // Remove last cell from each row
        const rows = document.querySelectorAll("#customTable tbody tr");
        rows.forEach(row => {
            row.deleteCell(row.cells.length - 1);
        });
    }
    </script>

</div>

</div>
