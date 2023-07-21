

  // Function to handle search
  function handleSearch() {
    const searchInput = document.getElementById('searchInput');
    const filter = searchInput.value.toUpperCase();
    const tableRows = document.querySelectorAll('#tableBody tr');

    tableRows.forEach((row) => {
      const cells = row.getElementsByTagName('td');
      let found = false;
      for (let i = 0; i < cells.length; i++) {
        const cellText = cells[i].textContent || cells[i].innerText;
        if (cellText.toUpperCase().indexOf(filter) > -1) {
          found = true;
          break;
        }
      }
      row.style.display = found ? '' : 'none';
    });
  }

  // Add event listener to the search input
  document.getElementById('searchInput').addEventListener('input', handleSearch);