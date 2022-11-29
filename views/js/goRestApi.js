const sourceSelect = document.querySelector('.selectpicker-source');
let parameters = window.location.search;

sourceSelect.addEventListener('change', () => {
    let paramString = '';
    const searchString = new URLSearchParams(parameters);
    const page = searchString.get('page');

    if (page)
        paramString += '?page=' + page + '&';
    else
        paramString = '?';
    paramString += 'source=' + sourceSelect.value;
    document.location.replace(document.location.pathname + paramString);
});
