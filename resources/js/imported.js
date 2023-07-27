// Get the current date
const currentDate = new Date();
// Format the current date as "YYYY-MM-DD" (required by the date input)
const formattedDate = currentDate.toISOString().slice(0, 10);
// Set the value of the input field to the current date
document.getElementById("recivedate").value = formattedDate;


// Get the file input element
const fileInput = document.getElementById("book_file");
// Get the label element to display the file name
const fileLabel = document.getElementById("file_label");
// Add an event listener to the file input to listen for changes
fileInput.addEventListener("change", function() {
  // Check if any files are selected
  if (fileInput.files.length > 1) {
    // Display the name of the first selected file
    for (let i = 0; i<fileInput.files.length; i++) {
        fileLabel.textContent += "/" +fileInput.files[i].name;
    }
  }
});