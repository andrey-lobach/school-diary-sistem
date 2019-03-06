const wrap = document.querySelector('.fields');
const filterDirection = document.querySelector('.filter_direction');
const filterField = document.querySelector('.filter_field');
const fields = wrap.getElementsByTagName('div');
form = document.getElementsByTagName('form')[0];

function clear() {
    for (i = 0; i < fields.length; i++) {
        fields[i].classList.remove('asc');
        fields[i].classList.remove('desc');
    }
}

wrap.addEventListener('click', () => {
    current = event.target;
    filterField.value = current.dataset.fld;
    if (!current.classList.contains('asc') && !current.classList.contains('desc')) {
        clear();
        current.classList.add('asc');
        filterDirection.value = 'asc';
    } else if (current.classList.contains('asc')) {
        current.classList.remove('asc');
        current.classList.add('desc');
        filterDirection.value = 'desc';
    } else {
        current.classList.remove('desc');
        current.classList.add('asc');
        filterDirection.value = 'asc';
    }
    form.submit();
});
const perPageElement = document.getElementsByClassName('per_page_select')[0];
perPageElement.addEventListener('change', () => form.submit());
const pages = document.getElementsByClassName('pages')[0];
const offset = document.getElementsByClassName('offset')[0];
const currentPageElement = document.getElementsByClassName('current_page')[0];
pages.addEventListener('click', () => {
    current = event.target;
    if (current.classList.contains('page')) {
        offset.value = (current.innerText - 1) * perPageElement.value;
        currentPageElement.value = parseInt(current.innerText, 10);
    }
});
const numberOfPages = parseInt(document.getElementsByClassName('number_of_pages')[0].value, 10);
const prev = pages.getElementsByClassName('prev')[0];
prev.addEventListener('click', () => {
    if (currentPageElement.value > 1) {
        currentPageElement.value -= 1;
        offset.value -= perPageElement.value;
    }
});
const next = pages.getElementsByClassName('next')[0];
next.addEventListener('click', () => {
    if (currentPageElement.value < numberOfPages) {
        const currentOffset = parseInt(offset.value, 10);
        const currentPage = parseInt(currentPageElement.value, 10);
        const perPage = parseInt(perPageElement.value, 10);
        offset.value = currentOffset + perPage;
        currentPageElement.value = currentPage + 1;
    }
});
const submitButton = document.getElementsByClassName('submit_button')[0];
submitButton.addEventListener('click', () => {
    currentPageElement.value = 1;
    offset.value = 0;
});
