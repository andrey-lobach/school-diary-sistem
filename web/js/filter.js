
  const wrap = document.querySelector('.fields');
  const filterDirection = document.querySelector('.filter_direction');
  const filterField = document.querySelector('.filter_field');
  const fields = wrap.getElementsByTagName('div');
  function clear(){
    for(i = 0; i < fields.length; i++){
      fields[i].classList.remove('asc');
      fields[i].classList.remove('desc');
    }
  }
  wrap.addEventListener('click', () => {
    current = event.target;
    filterField.value = current.id;
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
  });

