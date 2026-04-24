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
                let rows = document.querySelectorAll(`#${tableId} tbody tr`);
                rows.forEach(row => {
                    let text = row.innerText.toLowerCase();
                    row.style.display = text.includes(value) ? '' : 'none';
                });
            });
        }
    }
