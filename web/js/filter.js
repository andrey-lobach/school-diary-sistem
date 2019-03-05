
  const wrap = document.querySelector('.fields');
  const filterDirection = document.querySelector('.filter_direction');
  const filterField = document.querySelector('.filter_field');
  const fields = wrap.getElementsByTagName('div');
  form = document.getElementsByTagName('form')[0];
  function clear(){
    for(i = 0; i < fields.length; i++){
      fields[i].classList.remove('asc');
      fields[i].classList.remove('desc');
    }
  }
  wrap.addEventListener('click', () => {
    current = event.target;
    //TODO
    //filterField.value = current.data('field');
    filterField.value = current.id; // delete
    if (!current.classList.contains('asc') && !current.classList.contains('desc')) {
      clear();
      current.classList.add('asc');
      filterDirection.value='asc';
    } else if (current.classList.contains('asc')) {
      current.classList.remove('asc');
      current.classList.add('desc');
      filterDirection.value='desc';
    } else {
      current.classList.remove('desc');
      current.classList.add('asc');
      filterDirection.value='asc';
    }
    form.submit();
  });
  const perPage = document.getElementsByClassName('per_page_select')[0];
  perPage.addEventListener('change', () => form.submit());
  const pages = document.getElementsByClassName('pages')[0];
  const offset = document.getElementsByClassName('offset')[0];
  pages.addEventListener('click', ()=>{
    current = event.target;
    if (current.tagName === 'BUTTON') {
      offset.value=current.innerText;
    }
  });
