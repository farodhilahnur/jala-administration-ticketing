var ComponentsCodeEditors = function () {


    var handleDemo3 = function () {
        var myTextArea = document.getElementById('code_editor_demo_3');
        var myCodeMirror = CodeMirror.fromTextArea(myTextArea, {
            lineNumbers: true,
            matchBrackets: true,
            styleActiveLine: true,
            theme: "neat",
            mode: 'javascript',
            readOnly: true
        });
    }


    return {
        //main function to initiate the module
        init: function () {
            handleDemo3();
        }
    };

}();

jQuery(document).ready(function () {
    ComponentsCodeEditors.init();
});