document.addEventListener('DOMContentLoaded', function () {
    const facultyGrid = document.getElementById('faculty-grid');
    if (!facultyGrid) return;

    const dept = facultyGrid.getAttribute('data-dept') || 'AERO';

    fetch(`get_faculty.php?dept=${dept}`)
        .then(response => response.json())
        .then(result => {
            if (result.success) {
                renderFaculty(result.data);
            } else {
                console.error('Error fetching faculty:', result.message);
            }
        })
        .catch(error => console.error('Error:', error));

    function renderFaculty(facultyList) {
        facultyGrid.innerHTML = '';
        const modalContainer = document.createElement('div');
        modalContainer.id = 'dynamic-faculty-modals';
        document.body.appendChild(modalContainer);

        facultyList.forEach((faculty, index) => {
            const isExtra = index >= 3;
            const cardHtml = `
                <div class="col-lg-4 col-md-6 mb-4 faculty-card-item ${isExtra ? 'extra-faculty d-none' : ''}">
                    <div class="single-faculty-card">
                        <div class="faculty-img-wrapper">
                            <img src="${faculty.image_path}" alt="${faculty.name}">
                            <a href="mailto:${faculty.email}" class="social-link-overlay"><i class='bx bx-envelope'></i></a>
                        </div>
                        <div class="faculty-info">
                            <h3>${faculty.name}</h3>
                            <span class="designation">${faculty.designation}</span>
                            <div class="stats">
                                <p><i class='bx bx-briefcase'></i> ${faculty.experience}</p>
                                <p><i class='bx bxs-graduation'></i> ${faculty.qualification}</p>
                            </div>
                            <button class="btn-faculty-view" data-bs-toggle="modal" data-bs-target="#facultyModal${index}">
                                View Profile
                            </button>
                        </div>
                    </div>
                </div>
            `;
            facultyGrid.insertAdjacentHTML('beforeend', cardHtml);

            const modalHtml = `
                <div class="modal fade faculty-modal" id="facultyModal${index}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-xl modal-dialog-centered">
                        <div class="modal-content">
                            <button type="button" class="btn-close modal-btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            <div class="row g-0">
                                <div class="col-lg-4 faculty-modal-left">
                                    <img src="${faculty.image_path}" alt="${faculty.name}">
                                    <h3>${faculty.name}</h3>
                                    <p class="designation">${faculty.designation}</p>
                                    <ul class="quick-info-list">
                                        <li><i class='bx bx-book-bookmark'></i>
                                            <div><strong>Qualification:</strong> ${faculty.qualification}</div>
                                        </li>
                                        <li><i class='bx bx-calendar'></i>
                                            <div><strong>Joined:</strong> ${faculty.joined_date}</div>
                                        </li>
                                        <li><i class='bx bx-medal'></i>
                                            <div><strong>Specialization:</strong> ${faculty.specialization}</div>
                                        </li>
                                        <li><i class='bx bx-time'></i>
                                            <div><strong>Experience:</strong> ${faculty.experience}</div>
                                        </li>
                                        <li><i class='bx bx-user-check'></i>
                                            <div><strong>Association:</strong> ${faculty.association}</div>
                                        </li>
                                        <li><i class='bx bx-envelope'></i>
                                            <div><strong>Email:</strong> ${faculty.email}</div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-lg-8 faculty-modal-right">
                                    <h4>About Profile</h4>
                                    <p>${faculty.about}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            modalContainer.insertAdjacentHTML('beforeend', modalHtml);
        });

        // Toggle visibility logic
        const viewAllBtn = document.getElementById('view-all-faculty-btn');
        if (viewAllBtn && facultyList.length > 3) {
            let isExpanded = false; // Keep track of state locally

            viewAllBtn.addEventListener('click', function () {
                const extraFaculty = $('.extra-faculty');

                if (!isExpanded) {
                    // Show all faculty
                    extraFaculty.removeClass('d-none').hide().fadeIn(500);
                    this.innerHTML = "View Less Faculty <i class='bx bx-up-arrow-alt'></i>";
                    isExpanded = true;
                } else {
                    // Hide extra faculty
                    extraFaculty.fadeOut(300, function () {
                        $(this).addClass('d-none');
                    });
                    this.innerHTML = "View All Faculty <i class='bx bx-down-arrow-alt'></i>";
                    isExpanded = false;

                    // Scroll back to the top of the faculty section
                    $('html, body').animate({
                        scrollTop: $("#faculty-grid").offset().top - 100
                    }, 300);
                }
            });
        } else if (viewAllBtn) {
            viewAllBtn.parentElement.style.display = 'none';
        }
    }
});
