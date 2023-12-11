// flatpickr-init.js
const today = new Date();
const thirtyDaysAgo = new Date(today.getFullYear(), today.getMonth(), today.getDate() - 30);
let yesterday = new Date(today);
yesterday.setDate(today.getDate() - 1);
let selectedDate = yesterday;

const selectedDateString = document.getElementById('datepicker').value;
if (selectedDateString !== '') {
    selectedDate = new Date(selectedDateString);
}

flatpickr("#datepicker", {
    dateFormat: "Y-m-d",
    maxDate: yesterday,
    minDate: thirtyDaysAgo,
    defaultDate: selectedDate,
});
