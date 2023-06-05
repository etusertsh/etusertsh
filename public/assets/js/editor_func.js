function escapeHtml(unsafe) {
    return unsafe
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}

function selectFileWithCKFinder(elementId, previewid = '') {
    CKFinder.popup({
        chooseFiles: true,
        width: 800,
        height: 600,
        displayFoldersPanel: false,
        onInit: function (finder) {
            finder.on('files:choose', function (evt) {
                var file = evt.data.files.first();
                var output = document.getElementById(elementId);
                output.value = file.getUrl();
                if (previewid != '') {
                    var pre = document.getElementById(previewid);
                    pre.src = file.getUrl();
                }
            });

            finder.on('file:choose:resizedImage', function (evt) {
                var output = document.getElementById(elementId);
                output.value = evt.data.resizedUrl;
            });
        }
    });
}

function previewImage(targetid, imgfile) {
    document.getElementById(targetid).src = imgfile;
}