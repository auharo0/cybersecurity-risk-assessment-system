// Disable right-click context menu
document.addEventListener('contextmenu', function(e) {
    e.preventDefault();
    return false;
});

// Disable F12, Ctrl+Shift+I, Ctrl+Shift+J, Ctrl+U, Ctrl+Shift+C
document.addEventListener('keydown', function(e) {
    // F12
    if (e.key === 'F12') {
        e.preventDefault();
        return false;
    }
    
    // Ctrl+Shift+I (Inspect)
    if (e.ctrlKey && e.shiftKey && e.key === 'I') {
        e.preventDefault();
        return false;
    }
    
    // Ctrl+Shift+J (Console)
    if (e.ctrlKey && e.shiftKey && e.key === 'J') {
        e.preventDefault();
        return false;
    }
    
    // Ctrl+U (View Source)
    if (e.ctrlKey && e.key === 'u') {
        e.preventDefault();
        return false;
    }
    
    // Ctrl+Shift+C (Inspect Element)
    if (e.ctrlKey && e.shiftKey && e.key === 'C') {
        e.preventDefault();
        return false;
    }
    
    // Ctrl+S (Save page)
    if (e.ctrlKey && e.key === 's') {
        e.preventDefault();
        return false;
    }
});

// Detect if DevTools is open
(function() {
    var devtools = {
        isOpen: false,
        orientation: undefined
    };
    
    var threshold = 160;
    var emitEvent = function(state, orientation) {
        window.dispatchEvent(new CustomEvent('devtoolschange', {
            detail: {
                isOpen: state,
                orientation: orientation
            }
        }));
    };

    setInterval(function() {
        var widthThreshold = window.outerWidth - window.innerWidth > threshold;
        var heightThreshold = window.outerHeight - window.innerHeight > threshold;
        var orientation = widthThreshold ? 'vertical' : 'horizontal';

        if (!(heightThreshold && widthThreshold) &&
            ((window.Firebug && window.Firebug.chrome && window.Firebug.chrome.isInitialized) || widthThreshold || heightThreshold)) {
            if (!devtools.isOpen || devtools.orientation !== orientation) {
                emitEvent(true, orientation);
                devtools.isOpen = true;
                devtools.orientation = orientation;
                
                // Redirect or show warning when DevTools is detected
                alert('Developer tools are disabled for security reasons.');
                window.location.reload();
            }
        } else {
            if (devtools.isOpen) {
                emitEvent(false, undefined);
                devtools.isOpen = false;
                devtools.orientation = undefined;
            }
        }
    }, 500);
})();

// Disable text selection
document.addEventListener('selectstart', function(e) {
    e.preventDefault();
    return false;
});

// Disable copy
document.addEventListener('copy', function(e) {
    e.preventDefault();
    return false;
});

// Disable cut
document.addEventListener('cut', function(e) {
    e.preventDefault();
    return false;
});

// Clear console periodically
if (window.console) {
    setInterval(function() {
        console.clear();
    }, 1000);
}

console.log('%cStop!', 'color: red; font-size: 50px; font-weight: bold;');
console.log('%cThis is a browser feature intended for developers. If someone told you to copy-paste something here, it is a scam and will give them access to your account.', 'font-size: 16px;');
