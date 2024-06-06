let timeout = null;

const searchInput = document.getElementById('search');
const searchResults = document.getElementById('searchResults');

const handleSearch = () => {
  fetch(`/api/search?query=${searchInput.value}`, {
    method: 'GET',
    headers: {
      'Content-Type': 'application/json',
      "X-localization": document.documentElement.lang,
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    },
  })
    .then(response => response.text())
    .then(data => {
      searchResults.classList.remove('hidden')
      searchResults.classList.add('flex')
      searchResults.innerHTML = data
    });
}

const handleSearchDebounced = () => {
  clearTimeout(timeout);
  timeout = setTimeout(handleSearch, 500);
}

searchInput.addEventListener('input', () => {
  if (searchInput.value.length === 0) {
    searchResults.classList.add('hidden');
    searchResults.classList.remove('flex');
    searchResults.innerHTML = '';
    return;
  }

  handleSearchDebounced()
});

document.addEventListener('click', (event) => {
  if (searchResults.children.length === 0) return;

  if (event.target === searchInput) {
    searchResults.classList.remove('hidden')
    searchResults.classList.add('flex')
    return;
  }

  searchResults.classList.add('hidden')
});