document.addEventListener('DOMContentLoaded', () => {
    let elems = document.querySelectorAll('.select-filter');
    //console.log(elems);
    const options = {
        classes: 'select select--filter'
    }
    let filter = M.FormSelect.init(elems, options);
});