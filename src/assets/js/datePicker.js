document.addEventListener('DOMContentLoaded', createDatePicker);

function createDatePicker() {
    let elems = document.querySelectorAll('.datepicker');
    const options = {
        format: 'yyyy-mm-dd',
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

            weekdaysShort: [
                'Niedz',
                'Pon',
                'Wt',
                'Śr',
                'Czw',
                'Pt',
                'Sob'
            ],

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
            ]
        }
    }
    let datepicker = M.Datepicker.init(elems, options);
}