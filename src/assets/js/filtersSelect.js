document.addEventListener('DOMContentLoaded', () => {
    let elems = document.querySelectorAll('.select-filter');
    //console.log(elems);
    const options = {
      classes: 'select select--filter',
      isMultiple: true
    };
    let filter = M.FormSelect.init(elems, options);
});