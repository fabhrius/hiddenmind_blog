((Themify,doc,vars)=>{
    'use strict';
    const comments = doc.tfId('cancel-comment-reply-link').closest('#comments');
    if (comments) {
        const load = function () {
            this.tfOff('focusin pointerenter', load, {once: true, passive: true});
            Themify.loadJs(vars.commentUrl,!!window.addComment,vars.wp);
        };
        comments.tfOn('focusin pointerenter', load, {once: true, passive: true});
    }

})(Themify,document, themify_vars);