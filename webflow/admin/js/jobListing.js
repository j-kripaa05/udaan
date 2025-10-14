// Example job listing data based on your screenshot
const jobs = [
  { title: "Tailoring", company: "RK Fabrics", location: "Rajkot, India", type: "Part-time", salary: "₹25,000", applicants: 30 },
  { title: "Handicraft Artisan", company: "CraftWorld", location: "Rajkot, India", type: "Part-time", salary: "₹25,000", applicants: 30 },
  { title: "Data Entry", company: "SkillHub", location: "Jaipur, India", type: "Part-time", salary: "₹25,000", applicants: 30 },
  { title: "Tailoring", company: "RK Fabrics", location: "Rajkot, India", type: "Part-time", salary: "₹18,000", applicants: 30 },
  { title: "Tailoring", company: "RK Fabrics", location: "Delhi, India", type: "Part-time", salary: "₹25,000", applicants: 8 },
  { title: "Tailoring", company: "RK Fabrics", location: "Rajkot, India", type: "Part-time", salary: "₹25,000", applicants: 30 },
  { title: "Tailoring", company: "RK Fabrics", location: "Rajkot, India", type: "Part-time", salary: "₹25,000", applicants: 23 },
  { title: "Tailoring", company: "RK Fabrics", location: "Rajkot, India", type: "Part-time", salary: "₹25,000", applicants: 14 },
  { title: "Tailoring", company: "RK Fabrics", location: "Rajkot, India", type: "Part-time", salary: "₹25,000", applicants: 30 },
];

// Fill the job listing table
const tableBody = document.getElementById("jobTable");
jobs.forEach((job, index) => {
  const row = `
    <tr>
      <td>0${index + 1}</td>
      <td>${job.title}</td>
      <td>${job.company}</td>
      <td>${job.location}</td>
      <td>${job.type}</td>
      <td>${job.salary}</td>
      <td>${job.applicants}</td>
      <td class="actions"><i class="fa-solid fa-ellipsis"></i></td>
    </tr>
  `;
  tableBody.innerHTML += row;
});

// Search functionality
const searchInput = document.getElementById("searchInput");
searchInput.addEventListener("keyup", function () {
  const term = searchInput.value.toLowerCase();
  const rows = document.querySelectorAll("#companyTable tr");
  rows.forEach(row => {
    const text = row.textContent.toLowerCase();
    row.style.display = text.includes(term) ? "" : "none";
  });
});
