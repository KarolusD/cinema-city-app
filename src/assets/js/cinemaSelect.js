document.addEventListener('DOMContentLoaded', () => {
  let elems = document.querySelectorAll('.select-cinema');
  //console.log(elems);
  const options = {
    classes: 'select select--cinema'
  };
  let cinema = M.FormSelect.init(elems, options);
});
