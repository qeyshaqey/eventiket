    function tab(x) {
        const sections = ['k', 't', 'p'];
        const buttons = ['b1', 'b2', 'b3'];

        sections.forEach(id => {
            let el = document.getElementById(id);
            if (el) el.classList.add('hidden');
        });

        buttons.forEach(id => {
            let btn = document.getElementById(id);
            if (btn) {
                btn.classList.remove('bg-[#192853]', 'text-white');
                btn.classList.add('bg-white', 'text-yellow-400');
            }
        });

        let targetSection = document.getElementById(x);
        if (targetSection) targetSection.classList.remove('hidden');

        let active = {
            k: 'b1',
            t: 'b2',
            p: 'b3'
        };
        let btn = document.getElementById(active[x]);
        if (btn) {
            btn.classList.remove('bg-white', 'text-yellow-400');
            btn.classList.add('bg-[#192853]', 'text-white');
        }
    }

    // SEARCH
    function setupSearch(inputId, tableId) {
        let inputEl = document.getElementById(inputId);
        if (inputEl) {
            inputEl.addEventListener('keyup', function() {
                let value = this.value.toLowerCase();
                let tbody = document.querySelector(`#${tableId} tbody`);
                if (!tbody) return;
                
                let rows = tbody.querySelectorAll('tr:not(.empty-row)');
                let visibleCount = 0;
                
                rows.forEach(row => {
                    let text = row.innerText.toLowerCase();
                    let show = text.includes(value);
                    row.style.display = show ? '' : 'none';
                    if (show) visibleCount++;
                });
                
                let emptyRow = tbody.querySelector('.empty-row');
                if (visibleCount === 0) {
                    if (!emptyRow) {
                        let thead = document.querySelector(`#${tableId} thead tr`);
                        let colCount = thead ? thead.children.length : 10;
                        emptyRow = document.createElement('tr');
                        emptyRow.className = 'empty-row bg-white';
                        emptyRow.innerHTML = `<td colspan="${colCount}" class="py-8 px-4 text-center text-gray-500 font-medium">Data tidak tersedia</td>`;
                        tbody.appendChild(emptyRow);
                    }
                    emptyRow.style.display = '';
                } else if (emptyRow) {
                    emptyRow.style.display = 'none';
                }
            });
        }
    }
