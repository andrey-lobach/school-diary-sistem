(function(){
  const main = document.querySelector('.fields');
  const directionHidden = document.querySelector('.direction-hidden');
  const fieldHidden = document.querySelector('.field-hidden');
  const fields = main.querySelectorAll('.field');

  function clear() {
    for(let i = 0; i < fields.length; i++) {
      fields[i].firstChild.classList.remove('asc', 'desc');
    }
  }

  for(let i = 0; i < fields.length; i++) {
    const current = fields[i];
    const text = current.innerText;
    current.addEventListener('click', () => {
      if(current.firstChild.classList.contains('asc')) {
        current.firstChild.classList.replace('asc', 'desc');
        directionHidden.value = 'desc';
        fieldHidden.value = text;
      } else if(current.firstChild.classList.contains('desc')) {
        current.firstChild.classList.replace('desc', 'asc');
        directionHidden.value = 'asc';
        fieldHidden.value = text;
      } else {
        clear();
        current.firstChild.classList.add('asc');
        directionHidden.value = 'asc';
        fieldHidden.value = text;
      }
    });
  }
}());