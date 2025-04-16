document.addEventListener("DOMContentLoaded", () => {
    const daySelect = document.getElementById("dayInput");
    const monthSelect = document.getElementById("monthInput");
    const yearSelect = document.getElementById("yearInput");
  
    const populateYears = () => {
      for (let year = 2025; year >= 1900; year--) {
        const option = document.createElement("option");
        option.value = year;
        option.textContent = year;
        yearSelect.appendChild(option);
      }
    };
  
    const populateMonths = () => {
      const months = [
        "January", "February", "March", "April", "May", "June",
        "July", "August", "Septemper", "October", "November", "December"
      ];
  
      months.forEach((month, index) => {
        const option = document.createElement("option");
        option.value = index + 1;
        option.textContent = month;
        monthSelect.appendChild(option);
      });
    };
  
    const updateDays = () => {
      const selectedYear = parseInt(yearSelect.value);
      const selectedMonth = parseInt(monthSelect.value);
  
      if (isNaN(selectedMonth)) return;
  
      // Determine the number of days in the selected month
      const daysInMonth = new Date(selectedYear || 2000, selectedMonth, 0).getDate();
  
      // Clear existing days
      daySelect.innerHTML = '<option value="" disabled selected>Day</option>';
  
      for (let i = 1; i <= daysInMonth; i++) {
        const option = document.createElement("option");
        option.value = i;
        option.textContent = i;
        daySelect.appendChild(option);
      }
    };
  
    populateYears();
    populateMonths();
  
    // Initial day population
    updateDays();
  
    // Update days whenever month or year is changed
    monthSelect.addEventListener("change", updateDays);
    yearSelect.addEventListener("change", updateDays);


// SCRIPT FOR ADD NEW GUEST - TEST ONLY    

document.getElementById('addGuestBtn').addEventListener('click', function() {

    const originalForm = document.querySelector('.details-parent');

    const clonedForm = originalForm.cloneNode(true);

    const detailsFormContainer = document.getElementById('detailsFormContainer');

    const guestForms = detailsFormContainer.getElementsByClassName('details-parent');
    const guestNumber = guestForms.length + 1;

    const guestTitle = clonedForm.querySelector('.guest-title');
    guestTitle.textContent = `Adult ${guestNumber}`;

    detailsFormContainer.appendChild(clonedForm);
});

// SCRIPT FOR RESULT MODAL - TEST ONLY

document.getElementById('resultBtn').addEventListener('click', function() {
    // Collect all guest data
    const guestForms = document.querySelectorAll('.details-parent');
    let resultContent = '';

    guestForms.forEach((form, index) => {
        const title = form.querySelector('select[name="titleinput"]').value;
        const firstName = form.querySelector('input[name="first-name"]').value;
        const lastName = form.querySelector('input[name="last-name"]').value;
        const year = form.querySelector('select[name="year"]').value;
        const month = form.querySelector('select[name="month"]').value;
        const day = form.querySelector('select[name="day"]').value;
        const contact = form.querySelector('input[name="contact-number"]').value;
        const nationality = form.querySelector('input[name="nationality"]').value;
        const email = form.querySelector('input[name="email"]').value;
        const retypedEmail = form.querySelector('input[name="retypedemail"]').value;

        // Create the result content for each guest
        resultContent += `
            <div class="guest-summary">
                <h3>Adult ${index + 1}</h3>
                <p><strong>Name:</strong> ${title} ${firstName} ${lastName}</p>
                <p><strong>Date of Birth:</strong> ${month} ${day}, ${year}</p>
                <p><strong>Contact Number:</strong> ${contact}</p>
                <p><strong>Nationality:</strong> ${nationality}</p>
                <p><strong>Email:</strong> ${email}</p>
                <p><strong>Retyped Email:</strong> ${retypedEmail}</p>
                <hr />
            </div>
        `;
    });

    // Insert the result into the modal
    document.getElementById('modalContent').innerHTML = resultContent;

    // Show the modal
    const modal = document.getElementById('resultModal');
    modal.style.display = 'flex';
});

// Close the modal when the close button is clicked
document.getElementById('closeModalBtn').addEventListener('click', function() {
    const modal = document.getElementById('resultModal');
    modal.style.display = 'none';
});

// Close the modal when clicking outside of the modal content
window.addEventListener('click', function(event) {
    const modal = document.getElementById('resultModal');
    if (event.target === modal) {
        modal.style.display = 'none';
    }
});


});
  

