<style>
    /* Start by setting display:none to make this hidden.
   Then we position it in relation to the viewport window
   with position:fixed. Width, height, top and left speak
   for themselves. Background we set to 80% white with
   our animation centered, and no-repeating */
    .modal {
        display:    none;
        position:   fixed;
        z-index:    1000;
        top:        0;
        left:       0;
        height:     100%;
        width:      100%;
        background: rgba( 255, 255, 255, .8 ) 
                    url('https://thesectoreight.com/public/img/loader.gif') 
                    50% 50% 
                    no-repeat;
    }
    
    /* When the body has the loading class, we turn
       the scrollbar off with overflow:hidden */
    body.loading .modal {
        overflow: hidden;   
    }
    
    /* Anytime the body has the loading class, our
       modal element will be visible */
    body.loading .modal {
        display: block;
    }
</style>

  <div class="modal"><!-- Place at bottom of page --></div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>

    $body = $("body");
    downloadFile();
    function downloadFile () {
      
    $body.addClass("loading");
      $.ajax({
        url: "https://api.airslate.io/v1/organizations/{{$organization_id}}/templates/{{$template_id}}/flows/{{$flow_id}}/download?fillable_fields=true",
        type: "GET",
        headers: {
            "Accept": "application/zip",
            "Authorization": 'Bearer '+"<?= $token_data['access_token'] ?>",
        },
        xhrFields: {
            responseType: 'blob' // Important for handling binary data
        },
        success: function(response) {
            var blob = new Blob([response], { type: 'application/pdf' }); // Adjust MIME type if needed
            var link = document.createElement('a');
            link.href = window.URL.createObjectURL(blob);
            link.download = "document.zip"; // Specify the filename here
            document.body.appendChild(link);
            $body.removeClass("loading");
            link.click();
            document.body.removeChild(link);
            window.close()
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error("Error: " + textStatus, errorThrown);
        }
    });

  }
</script>