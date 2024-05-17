@include('partials.admin.head')
<!-- @include('partials.admin.footer') -->

<div class="editor-container" style="height:700px"></div>
<script src="https://editor.unlayer.com/embed.js"></script>
<script>
    $('.formatter').click(function() {
        $("#edito").css("display", "block");
        $("#formatting").css("display", "none");
    });
    $(document).ready(function(){
        var unlayer = $('#editor-container').unlayer({
            apiKey: '1JIEPtRKTHWUcY5uMLY4TWFs2JHUbYjAcZIyd6ubblfukgU6XfAQkceYXUzI1DpR',
        });
    })
    unlayer.init({
        id: 'editor-container',
        projectId: 119381,
        displayMode: 'email'
    });
</script>