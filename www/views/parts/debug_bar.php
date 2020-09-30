<script>
    (async () => {
        function getCookie(name) {
            const value = `; ${document.cookie}`;
            const parts = value.split(`; ${name}=`);
            if (parts.length === 2) return parts.pop().split(';').shift();
        }

        const entries = JSON.parse(decodeURIComponent(getCookie('DEBUG_BAR_ENTRIES') || '[]').replace(/\+/g, ' '));

        let debugBar = document.createElement('div');
        debugBar.classList.add('debug-bar');
        debugBar.innerHTML = Object.keys(entries).map(name => {
            let section = `<div class="debug-bar-title">${name}</div>`;
            let entry = entries[name];

            if (typeof entry === 'string') {
                section += `<div class="debug-bar-section-items">${entry}</div>`;
            } else if (typeof entry === 'object') {
                section += entry.map(e => `<div class="debug-bar-section-items">${e}</div>`).join('');
            }

            return `<div class="debug-bar-section ${name === 'Queries' ? 'full-width' : ''}">${section}</div>`;
        }).join('');

        let openButton = document.createElement('button');
        openButton.classList.add('debug-bar-button', 'debug-bar-button-open');
        openButton.innerHTML = 'Debug';
        openButton.onclick = e => {
            e.preventDefault();
            document.querySelector('.debug-bar').classList.toggle('open');
        }

        let closeButton = document.createElement('button');
        closeButton.classList.add('debug-bar-button', 'debug-bar-button-close');
        closeButton.title = 'Fermer';
        closeButton.innerHTML = '×';
        closeButton.onclick = e => {
            e.preventDefault();
            document.querySelector('.debug-bar').classList.toggle('open');
        }

        document.body.appendChild(openButton);
        debugBar.appendChild(closeButton);
        document.body.appendChild(debugBar);
    })()
</script>
