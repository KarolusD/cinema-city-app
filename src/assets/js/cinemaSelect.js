document.addEventListener('DOMContentLoaded', () => {
    let elems = document.querySelectorAll('select');
    const options = {
        classes: 'select select--cinema'
    }
    let cinemaSelect = M.FormSelect.init(elems, options);
});