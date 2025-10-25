// main.js: fetch movies and render
async function fetchMovies(q=''){
  const url = 'api/get_movies.php' + (q ? '?q=' + encodeURIComponent(q) : '');
  const res = await fetch(url);
  const movies = await res.json();
  const container = document.getElementById('movies');
  container.innerHTML = '';
  movies.forEach(m => {
    const div = document.createElement('div');
    div.className = 'movie-card';
    div.innerHTML = `
      <img src="../uploads/posters/${m.poster || 'placeholder.jpg'}" alt="${m.title}">
      <div class="body">
        <h3>${m.title}</h3>
        <p>${m.genre} • ${m.duration} min</p>
        <a class="button" href="show_timings.php?movie_id=${m.id}">Book Ticket</a>
      </div>
    `;
    container.appendChild(div);
  });
}

document.getElementById('search').addEventListener('input', e => {
  fetchMovies(e.target.value);
});

// initial load
fetchMovies();
