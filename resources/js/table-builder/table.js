// Table Builder Class
class TableBuilder {
    constructor() {
        this.tables = {};
        this.activeTab = null;
        this.initializeEventListeners();
    }

    initializeEventListeners() {
        // Add tab button
        document.querySelector('.add-tab').addEventListener('click', () => this.addTab());

        // Tab switching
        document.querySelector('.tabs-header').addEventListener('click', (e) => {
            if (e.target.classList.contains('tab')) {
                this.switchTab(e.target.dataset.tabId);
            }
        });

        // Delete tab button
        document.querySelector('.tabs-header').addEventListener('click', (e) => {
            if (e.target.classList.contains('delete-tab')) {
                const tabId = e.target.closest('.tab-container').querySelector('.tab').dataset.tabId;
                this.deleteTab(tabId);
            }
        });

        // Table cell editing
        document.querySelector('.tab-content').addEventListener('click', (e) => {
            if (e.target.classList.contains('editable')) {
                this.makeEditable(e.target);
            }
        });

        // Save button
        document.querySelector('.save-btn').addEventListener('click', () => this.saveTable());

        // Load button
        document.querySelector('.load-btn').addEventListener('click', () => this.loadTable());

        // Export button
        document.querySelector('.export-btn').addEventListener('click', () => this.exportToExcel());
    }

    addTab() {
        const tabId = Date.now().toString();
        const tabName = `Sheet ${Object.keys(this.tables).length + 1}`;
        
        // Create tab header
        const tabContainer = document.createElement('div');
        tabContainer.className = 'tab-container';
        tabContainer.innerHTML = `
            <button class="tab" data-tab-id="${tabId}">${tabName}</button>
            <button class="delete-tab"><i class="fas fa-times"></i></button>
        `;
        document.querySelector('.tabs-header').appendChild(tabContainer);

        // Create tab content
        const tabContent = document.createElement('div');
        tabContent.className = 'tab-content';
        tabContent.id = `tab-${tabId}`;
        tabContent.innerHTML = this.createTableHTML();
        document.querySelector('.tabs-container').appendChild(tabContent);

        // Initialize table data
        this.tables[tabId] = {
            name: tabName,
            data: this.initializeTableData()
        };

        // Switch to new tab
        this.switchTab(tabId);
    }

    switchTab(tabId) {
        // Update active tab
        document.querySelectorAll('.tab').forEach(tab => {
            tab.classList.toggle('active', tab.dataset.tabId === tabId);
        });
        document.querySelectorAll('.tab-content').forEach(content => {
            content.classList.toggle('active', content.id === `tab-${tabId}`);
        });
        this.activeTab = tabId;
    }

    deleteTab(tabId) {
        if (Object.keys(this.tables).length <= 1) {
            alert('Cannot delete the last tab');
            return;
        }

        if (confirm('Are you sure you want to delete this tab?')) {
            // Remove tab header and content
            document.querySelector(`.tab[data-tab-id="${tabId}"]`).closest('.tab-container').remove();
            document.querySelector(`#tab-${tabId}`).remove();

            // Remove table data
            delete this.tables[tabId];

            // Switch to another tab
            const remainingTabId = Object.keys(this.tables)[0];
            this.switchTab(remainingTabId);
        }
    }

    createTableHTML() {
        return `
            <div class="table-actions">
                <button class="add-row-btn"><i class="fas fa-plus"></i> Add Row</button>
                <button class="add-col-btn"><i class="fas fa-plus"></i> Add Column</button>
                <button class="delete-row-btn"><i class="fas fa-minus"></i> Delete Row</button>
                <button class="delete-col-btn"><i class="fas fa-minus"></i> Delete Column</button>
            </div>
            <table>
                <thead>
                    <tr>
                        <th></th>
                        <th>A</th>
                        <th>B</th>
                        <th>C</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td class="editable"></td>
                        <td class="editable"></td>
                        <td class="editable"></td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td class="editable"></td>
                        <td class="editable"></td>
                        <td class="editable"></td>
                    </tr>
                </tbody>
            </table>
        `;
    }

    initializeTableData() {
        return [
            ['', '', ''],
            ['', '', '']
        ];
    }

    makeEditable(cell) {
        const input = document.createElement('input');
        input.type = 'text';
        input.value = cell.textContent;
        input.className = 'cell-input';
        
        input.addEventListener('blur', () => {
            cell.textContent = input.value;
            this.updateTableData();
        });

        input.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                input.blur();
            }
        });

        cell.textContent = '';
        cell.appendChild(input);
        input.focus();
    }

    updateTableData() {
        const table = document.querySelector(`#tab-${this.activeTab} table`);
        const rows = table.querySelectorAll('tbody tr');
        const data = [];

        rows.forEach(row => {
            const rowData = [];
            row.querySelectorAll('td:not(:first-child)').forEach(cell => {
                rowData.push(cell.textContent);
            });
            data.push(rowData);
        });

        this.tables[this.activeTab].data = data;
    }

    async saveTable() {
        try {
            const response = await fetch('/table-builder/save', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    name: this.tables[this.activeTab].name,
                    data: this.tables[this.activeTab].data
                })
            });

            const result = await response.json();
            if (result.success) {
                alert('Table saved successfully');
            } else {
                throw new Error(result.message);
            }
        } catch (error) {
            alert('Failed to save table: ' + error.message);
        }
    }

    async loadTable() {
        try {
            const response = await fetch('/table-builder/list');
            const result = await response.json();
            
            if (result.success) {
                const tableList = document.createElement('div');
                tableList.className = 'table-list';
                tableList.innerHTML = '<h3>Saved Tables</h3>';
                
                const list = document.createElement('ul');
                result.data.forEach(table => {
                    const item = document.createElement('li');
                    item.innerHTML = `
                        <span>${table.name}</span>
                        <button class="load-table-btn" data-id="${table.id}">Load</button>
                        <button class="delete-table-btn" data-id="${table.id}">Delete</button>
                    `;
                    list.appendChild(item);
                });
                
                tableList.appendChild(list);
                document.body.appendChild(tableList);

                // Add event listeners for load and delete buttons
                tableList.addEventListener('click', async (e) => {
                    if (e.target.classList.contains('load-table-btn')) {
                        await this.loadTableData(e.target.dataset.id);
                        tableList.remove();
                    } else if (e.target.classList.contains('delete-table-btn')) {
                        if (confirm('Are you sure you want to delete this table?')) {
                            await this.deleteTable(e.target.dataset.id);
                            e.target.closest('li').remove();
                        }
                    }
                });
            } else {
                throw new Error(result.message);
            }
        } catch (error) {
            alert('Failed to load table list: ' + error.message);
        }
    }

    async loadTableData(id) {
        try {
            const response = await fetch('/table-builder/load', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ id })
            });

            const result = await response.json();
            if (result.success) {
                this.tables[this.activeTab].data = result.data;
                this.renderTableData();
            } else {
                throw new Error(result.message);
            }
        } catch (error) {
            alert('Failed to load table: ' + error.message);
        }
    }

    async deleteTable(id) {
        try {
            const response = await fetch('/table-builder/delete', {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ id })
            });

            const result = await response.json();
            if (!result.success) {
                throw new Error(result.message);
            }
        } catch (error) {
            alert('Failed to delete table: ' + error.message);
        }
    }

    renderTableData() {
        const table = document.querySelector(`#tab-${this.activeTab} table tbody`);
        table.innerHTML = '';

        this.tables[this.activeTab].data.forEach((row, rowIndex) => {
            const tr = document.createElement('tr');
            tr.innerHTML = `<td>${rowIndex + 1}</td>`;
            
            row.forEach(cell => {
                const td = document.createElement('td');
                td.className = 'editable';
                td.textContent = cell;
                tr.appendChild(td);
            });

            table.appendChild(tr);
        });
    }

    exportToExcel() {
        const table = document.querySelector(`#tab-${this.activeTab} table`);
        const wb = XLSX.utils.table_to_book(table, { sheet: this.tables[this.activeTab].name });
        XLSX.writeFile(wb, `${this.tables[this.activeTab].name}.xlsx`);
    }
}

// Initialize table builder when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    window.tableBuilder = new TableBuilder();
}); 