// Sidebar button
let sidebarButton = document.getElementById('sidebar-button');
if (sidebarButton) {
    sidebarButton.addEventListener('click', event => {
        event.preventDefault();

        let sidebarSection = document.querySelector('.sidebar .sidebar-sections');
        let sidebar = document.querySelector('.sidebar');
        sidebarSection.classList.toggle('sidebar-open');
        sidebar.classList.toggle('display-xs-none');
        sidebar.classList.toggle('display-sm-none');
        sidebar.classList.toggle('display-md-block');
    });
}

// Add module buttons
let addModuleInput = document.getElementById('add-module');
let addModuleButton = document.getElementById('add-module-button');
if (addModuleInput && addModuleButton) {
    addModuleButton.addEventListener('click', event => {
        event.preventDefault();

        document.location.href = event.currentTarget.getAttribute('data-url') + '&add-module=' + addModuleInput.value;
    });
}

// Add module children buttons
let addModuleChildrenButtons = document.querySelectorAll('.form .add-module-children');
if (addModuleChildrenButtons) {
    addModuleChildrenButtons.forEach(button => button.addEventListener('click', function (e) {
        let previousFieldset = e.currentTarget.previousElementSibling;
        let newFieldset = previousFieldset.cloneNode(true);

        e.currentTarget.parentNode.insertBefore(newFieldset, previousFieldset);

        let newFieldsetIndex = Number(newFieldset.querySelector('legend').innerText) + 1;

        newFieldset.nextElementSibling.querySelectorAll('input, textarea').forEach(input => input.value = '');
        newFieldset.nextElementSibling.querySelector('legend').innerText = String(newFieldsetIndex);
        newFieldset.nextElementSibling.querySelectorAll('label, input, textarea').forEach(element => {
            if (element.tagName === 'LABEL') {
                let currentIdentifier = element.getAttribute('for');
                let newIdentifier = currentIdentifier.slice(0, -1) + (newFieldsetIndex - 1);

                element.setAttribute('for', newIdentifier);
            } else {
                let currentIdentifier = element.id;
                let newIdentifier = currentIdentifier.slice(0, -1) + (newFieldsetIndex - 1);

                element.name = newIdentifier;
                element.id = newIdentifier;
            }
        });
    }));
}

// Remove module children buttons
let removeModuleChildrenButtons = document.querySelectorAll('.form .remove-module-children');
if (removeModuleChildrenButtons) {
    removeModuleChildrenButtons.forEach(button => button.addEventListener('click', function (e) {
        let currentFieldset = e.currentTarget.parentNode;
        currentFieldset.parentNode.removeChild(currentFieldset);
    }));
}

// Delete button confirmation
let deleteButtons = document.querySelectorAll('a.link[href*="/suppression"]');
if (deleteButtons) {
    deleteButtons.forEach(button => button.addEventListener('click', function (event) {
        event.preventDefault();
        if (confirm('Confirmez-vous la suppression de cet élément ?')) {
            window.location.href = event.currentTarget.getAttribute('href');
        }
    }));
}
