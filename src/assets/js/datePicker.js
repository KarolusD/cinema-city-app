document.addEventListener('DOMContentLoaded', createDatePicker);

function createDatePicker() {
  let elems = document.querySelectorAll('.datepicker');
  let d = new Date();
  // const currDay = d.getDay();
  // const currMonth = d.getMonth();
  // const currYear = d.getFullYear();
  // const startDate = new Date(currYear, currMonth, currDay);
  // const newDate = new Date(
  //   startDate
  //     .toString()
  //     .split('-')
  //     .reverse()
  //     .join('-')
  // );
  const options = {
   format: 'dd-mm-yyyy',
    i18n: {
      cancel: 'Anuluj',
      done: 'Zatwierdź',
      clear: 'Wyczyść',
      weekdays: [
        'Niedziela',
        'Poniedziałek',
        'Wtorek',
        'Środa',
        'Czwartek',
        'Piątek',
        'Sobota'
      ],

      weekdaysShort: ['Niedz', 'Pon', 'Wt', 'Śr', 'Czw', 'Pt', 'Sob'],

      weekdaysAbbrev: ['ND', 'PN', 'WT', 'ŚR', 'CZ', 'PT', 'SB'],

      months: [
        'Styczeń',
        'Luty',
        'Marzec',
        'Kwiecień',
        'Maj',
        'Czerwiec',
        'Lipiec',
        'Sierpień',
        'Wrzesień',
        'Październik',
        'Listopad',
        'Grudzień'
      ],

      monthsShort: [
        'Sty',
        'Lut',
        'Mar',
        'Kwi',
        'Maj',
        'Cze',
        'Lip',
        'Sie',
        'Wrz',
        'Lis',
        'Paź',
        'Gru'
      ],
    },
    firstDay: 1,
    setDefaultDate: true,
    defaultDate: new Date()
  };
  let datepicker = M.Datepicker.init(elems, options);
  // let instance = M.Datepicker.getInstance(datepicker)
  // datepicker.setDate(new Date());
}
