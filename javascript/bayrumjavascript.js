function idleLogout() {
    var t;
    window.onload = resetTimer;
    window.onmousemove = resetTimer;
    window.onmousedown = resetTimer; // catches touchscreen presses
    window.onclick = resetTimer;     // catches touchpad clicks
    window.onscroll = resetTimer;    // catches scrolling with arrow keys
    window.onkeypress = resetTimer;

    function logout() {
        window.location.reload();
    }

    function resetTimer() {
        clearTimeout(t);
        // t = setTimeout(logout, 3100);  // time is in milliseconds
        t = setTimeout(logout, 7200000);  // time is in milliseconds
    }
}

idleLogout();
