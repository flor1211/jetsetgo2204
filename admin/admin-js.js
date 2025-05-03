document.addEventListener("DOMContentLoaded", function () {
  let sidebar = document.querySelector(".sidebar");
  let sidebarBtn = document.querySelector(".sidebarBtn");
  let homeSection = document.querySelector(".home-section");

  // Toggle sidebar visibility
  sidebarBtn.addEventListener("click", () => {
    sidebar.classList.toggle("active");
    homeSection.classList.toggle("active");
  });

  const dropdownToggles = document.querySelectorAll(".dropdown-toggle");

  dropdownToggles.forEach((toggle) => {
    toggle.addEventListener("click", function (e) {
      const parent = this.closest(".dropdown");
      parent.classList.toggle("open");

      dropdownToggles.forEach((otherToggle) => {
        if (otherToggle !== this) {
          otherToggle.closest(".dropdown").classList.remove("open");
        }
      });

      e.stopPropagation();
    });
  });

  document.addEventListener("click", function (e) {
    if (!sidebar.contains(e.target)) {
      dropdownToggles.forEach((toggle) => {
        toggle.closest(".dropdown").classList.remove("open");
      });
    }
  });
});
