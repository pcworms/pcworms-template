/**

 __          _______     _____ _    _          __  __  _____ _____
 \ \        / /  __ \   / ____| |  | |   /\   |  \/  |/ ____|_   _|
  \ \  /\  / /| |__) | | (___ | |__| |  /  \  | \  / | (___   | |
   \ \/  \/ / |  ___/   \___ \|  __  | / /\ \ | |\/| |\___ \  | |
	\  /\  /  | |       ____) | |  | |/ ____ \| |  | |____) |_| |_
	 \/  \/   |_|      |_____/|_|  |_/_/    \_\_|  |_|_____/|_____|


 * @version WP Shamsi aka افزونه شمسی ساز و فارسی ساز وردپرس  V4.1.1
 * @info https://wordpress.org/plugins/wp-shamsi/
 *
 */

jQuery(document).ready(function() {
    wpsh_num(document.body);
});

function wpsh_num(el) {
    persian = {
        0: '۰',
        1: '۱',
        2: '۲',
        3: '۳',
        4: '۴',
        5: '۵',
        6: '۶',
        7: '۷',
        8: '۸',
        9: '۹'
    };
    elements = [ // Tags to skip
        "CODE", "HEAD", "INPUT", "OPTION", "PRE", "SCRIPT", "STYLE", "TEXTAREA", "TITLE"
    ];
    if (el.nodeType == 3) {
        var parent = jQuery(el.parentElement).prop("tagName");
        var list = el.data.match(/[0-9]/g);
        var english = /[a-zA-Z]/g;
        for (var ii = 0; ii < elements.length; ii++) {
            if (jQuery(el).parents(elements[ii]).length > 0) {
                return;
            }
        }
        if (list !== null && list.length !== 0 && !english.test(el.data)) {
            for (var i = 0; i < list.length; i++) {
                el.data = el.data.replace(list[i], persian[list[i]]);
            }
        }
    }
    for (var i = 0; i < el.childNodes.length; i++) {
        wpsh_num(el.childNodes[i]);
    }
}

function all_query(query) {
    var els = document.querySelectorAll(query);
    for (var i = 0; i < els.length; ++i) {
        wpsh_num(els[i]);
    }
}