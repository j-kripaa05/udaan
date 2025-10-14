// Search functionality
const searchInput = document.getElementById("searchInput");
searchInput.addEventListener("keyup", function () {
  const term = searchInput.value.toLowerCase();
  // Ensure the target is the tbody, not the entire table
  const tableBody = document.getElementById("companyTable");
  const rows = tableBody.querySelectorAll("tr"); 
  
  rows.forEach(row => {
    // Get text content of all cells in the row
    const rowCells = row.querySelectorAll('td');
    let rowText = '';
    rowCells.forEach((cell, index) => {
        // Exclude the 'Actions' column from search (last column, index starting from 0)
        if (index < rowCells.length - 1) { 
            rowText += cell.textContent.toLowerCase() + ' ';
        }
    });

    row.style.display = rowText.includes(term) ? "" : "none";
  });
});