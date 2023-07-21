@extends('layouts.app')

<!-- Scripts -->
@vite(['resources/css/table.css' , 'resources/js/table.js'])

@section('content')
<body>
    <div class="container">
        <div class="text-center"><h2>Wi Table</h2></div>
        <div class="d-flex">
            <div class="flex-grow-1"><input type="text" id="searchInput" class="form-control mb-2" placeholder="Search..."></div>
            <div class="p-1 ms-2 export"><i class="bi bi-file-earmark-arrow-down"></i></div>
        </div>
        <!-- Table -->
        <div class="table-responsive">
            <table class="table table-hover ">

                <!-- Table Header -->
                <thead class="table-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Book_num</th>
                        <th scope="col">Creater</th>
                        <th scope="col">Subject</th>
                        <th scope="col">Created_date</th>
                        <th scope="col">Submit_by</th>
                        <th scope="col">Edit</th>
                        <th scope="col">Download</th>
                    </tr>
                </thead>

                <!-- Table Body -->
                <tbody class="table-group-divider" id="tableBody">
                    <!-- Table rows will be dynamically added here -->
                </tbody>
            </table>
        </div>
    </div>


    <script>
    // Sample data for the table
    const data = [
      { firstName: 'John', lastName: 'Doe', age: 30 },
      { firstName: 'Jane', lastName: 'Smith', age: 25 },
      { firstName: 'Jane', lastName: 'Smith', age: 25 },
      { firstName: 'Jane', lastName: 'Smith', age: 25 },
      { firstName: 'Jane', lastName: 'Smith', age: 25 },
      { firstName: 'Jane', lastName: 'Smith', age: 25 },
      { firstName: 'Jane', lastName: 'Smith', age: 25 },
      { firstName: 'Jane', lastName: 'Smith', age: 25 },
      { firstName: 'Jane', lastName: 'Smith', age: 25 },
      // Add more data as needed
    ];

    // Function to generate the table rows dynamically
    function generateTableRows() {
      const tableBody = document.getElementById('tableBody');
      tableBody.innerHTML = ''; // Clear the table body before generating rows

      let rowCount = 1;
      data.forEach((item) => {
        const row = `
          <tr>
            <td>${rowCount}</td>
            <td>${item.firstName}</td>
            <td>${item.lastName}</td>
            <td>${item.age}</td>
          </tr>
        `;
        tableBody.insertAdjacentHTML('beforeend', row);
        rowCount++;
      });
    }

    // Call the function to generate the table rows initially
    generateTableRows();

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
  </script>
</body>
@endsection