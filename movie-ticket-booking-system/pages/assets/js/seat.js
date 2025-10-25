// seat.js: fetch seat map and allow selecting seats
async function getSeats(){
  const res = await fetch('api/get_seats.php?show_id=' + SHOW_ID);
  const data = await res.json();
  renderSeats(data);
}

function renderSeats(data){
  const container = document.getElementById('seat-map');
  container.innerHTML = '';
  const rows = data.rows || 6;
  const cols = data.cols || 10;
  const booked = new Set((data.booked || []).map(s => s));
  for(let r=0;r<rows;r++){
    const rowEl = document.createElement('div');
    rowEl.style.display='flex';
    rowEl.style.gap='6px';
    for(let c=0;c<cols;c++){
      const seatNo = String.fromCharCode(65+r) + (c+1);
      const btn = document.createElement('button');
      btn.textContent = seatNo;
      btn.dataset.seat = seatNo;
      btn.disabled = booked.has(seatNo);
      btn.style.padding='8px 10px';
      btn.style.borderRadius='6px';
      if(booked.has(seatNo)) btn.style.opacity=0.5;
      btn.addEventListener('click', () => toggleSeat(btn));
      rowEl.appendChild(btn);
    }
    container.appendChild(rowEl);
  }
}

let selected = new Set();
function toggleSeat(btn){
  const s = btn.dataset.seat;
  if(selected.has(s)){ selected.delete(s); btn.style.background=''; }
  else { selected.add(s); btn.style.background='lightgreen'; }
}

document.getElementById('book').addEventListener('click', async ()=>{
  if(selected.size === 0){ alert('Select seats first'); return; }
  const seats = Array.from(selected);
  const res = await fetch('api/book_seats.php', {
    method:'POST', headers:{'Content-Type':'application/json'},
    body: JSON.stringify({ show_id: SHOW_ID, seats })
  });
  const data = await res.json();
  if(data.success){ alert('Booked!'); location.href='loginhome.php'; }
  else alert('Failed: ' + (data.message || 'unknown'));
});

getSeats();
