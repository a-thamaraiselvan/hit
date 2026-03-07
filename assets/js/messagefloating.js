function toggleContactOptions() {
    const mainButton = document.querySelector('.main-button');
    const options = document.getElementById('contactOptions');
    mainButton.classList.toggle('active');
    options.classList.toggle('active');
    
    // Change icon when active
    const icon = mainButton.querySelector('i');
    if (mainButton.classList.contains('active')) {
        icon.classList.remove('bx-message-dots');
        icon.classList.add('bx-plus');
    } else {
        icon.classList.remove('bx-plus');
        icon.classList.add('bx-message-dots');
    }
}   