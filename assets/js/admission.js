(function () {
    /* dot particles */
    var c = document.getElementById('admissionPopupDots');
    var cols = ['#ffd600', '#fff', '#90caf9', '#a5d6a7'];
    for (var i = 0; i < 18; i++) {
        var s = document.createElement('span');
        var sz = 4 + Math.random() * 7;
        s.style.cssText =
            'width:' + sz + 'px;height:' + sz + 'px;' +
            'background:' + cols[Math.floor(Math.random() * cols.length)] + ';' +
            'left:' + (Math.random() * 100) + '%;' +
            'top:' + (Math.random() * 100) + '%;' +
            '--d:' + (2.5 + Math.random() * 3) + 's;' +
            '--dl:' + (Math.random() * 2.5) + 's;';
        c.appendChild(s);
    }

    window.admissionPopupOpen = function () {
        document.getElementById('admissionPopupOverlay').classList.add('show');
    };
    window.admissionPopupClose = function () {
        document.getElementById('admissionPopupOverlay').classList.remove('show');
    };

    /* auto open after 2 sec */
    window.addEventListener('load', function () {
        setTimeout(admissionPopupOpen, 2000);
    });

    /* backdrop click */
    document.getElementById('admissionPopupOverlay').addEventListener('click', function (e) {
        if (e.target === this) admissionPopupClose();
    });

    /* escape key */
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') admissionPopupClose();
    });
})();